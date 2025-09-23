<script>
  import { Inertia } from '@inertiajs/inertia';

  export let page = "Admin Overzicht";
  export let search;
  export let begraafplaatsen;

  let searchTerm = search || '';

  function searchTable() {
    Inertia.get('/admin', { search: searchTerm }, { preserveState: true });
  }

  function navigate(url) {
    Inertia.visit(url, { preserveState: true });
  }

  // tijdelijke dummy data (6 items)
  let placeholders = Array(6).fill({
    naam: "Lorem ipsum",
    id: "999",
    locatie: "Maps locatie"
  });
</script>

<div class="container">
  <h1>{page}</h1>

  <!-- Zoekbalk -->
  <div class="search-container">
    <input type="text" bind:value={searchTerm} placeholder="Zoeken..." />
    <button on:click={searchTable}>Zoeken</button>
  </div>

  <!-- Grid met placeholder cards -->
  <div class="cards-grid">
    {#each placeholders as plaats}
      <div class="card">
        <!-- Afbeelding placeholder -->
        <div class="image-placeholder"></div>

        <div class="card-content">
          <h2>Graf gegevens</h2>
          <p>{plaats.naam}</p>
          <p>Grafnummer: {plaats.id}</p>
          <p>📍 {plaats.locatie}</p>
        </div>

        <button class="details-btn">Bekijk gegevens</button>
      </div>
    {/each}
  </div>

  <!-- Paginatie (dummy) -->
  <div class="pagination">
    <button disabled>Vorige</button>
    <button disabled>Volgende</button>
  </div>
</div>

<style>
.container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 2rem;
  font-family: sans-serif;
}

.search-container {
  margin-bottom: 1rem;
  display: flex;
  gap: 0.5rem;
}

.search-container input {
  flex: 1;
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.search-container button {
  padding: 0.5rem 1rem;
  border: none;
  background: rgb(59, 57, 57);
  color: white;
  border-radius: 4px;
  cursor: pointer;
}

.cards-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 1.5rem;
}

.card {
  border: 1px solid #ddd;
  border-radius: 8px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  background: white;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

.image-placeholder {
  width: 100%;
  height: 180px;
  background: #e5e7eb;
}

.card-content {
  padding: 1rem;
  flex: 1;
}

.card-content h2 {
  font-size: 1.2rem;
  margin-bottom: 0.5rem;
}

.details-btn {
  margin: 1rem;
  padding: 0.5rem;
  border: none;
  background: rgb(59, 57, 57);
  color: white;
  border-radius: 4px;
  cursor: pointer;
}

.pagination {
  margin-top: 1rem;
  display: flex;
  gap: 0.5rem;
  justify-content: center;
}
</style>
