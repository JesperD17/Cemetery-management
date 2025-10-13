<script>
  import { Inertia } from '@inertiajs/inertia';

  export let page = "Admin Overzicht";
  export let search;
  export let begraafplaatsen;

  let searchTerm = search || '';
  let showModal = false;
  let selectedPlaats = null;

  function searchTable() {
    Inertia.get('/admin', { search: searchTerm }, { preserveState: true });
  }

  function navigate(url) {
    Inertia.visit(url, { preserveState: true });
  }

  // ✅ tijdelijke mock-up data (blijft staan!)
  let placeholders = Array(6).fill({
    naam: "Lorem ipsum",
    id: "999",
    locatie: "Maps locatie"
  });

  // ✅ Modal openen
  function openModal(plaats) {
    selectedPlaats = plaats;
    showModal = true;
  }

  // ✅ Modal sluiten
  function closeModal() {
    showModal = false;
    selectedPlaats = null;
  }
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
        <div class="image-placeholder"></div>

        <div class="card-content">
          <h2>Graf gegevens</h2>
          <p>{plaats.naam}</p>
          <p>Grafnummer: {plaats.id}</p>
          <p>📍 {plaats.locatie}</p>
        </div>

        <button class="details-btn" on:click={() => openModal(plaats)}>Bekijk gegevens</button>
      </div>
    {/each}
  </div>

  <!-- Paginatie -->
  <div class="pagination">
    <button disabled>Vorige</button>
    <button disabled>Volgende</button>
  </div>
</div>

<!-- ✅ Popup Modal -->
{#if showModal}
  <div class="modal-backdrop" on:click={closeModal}>
    <div class="modal" on:click|stopPropagation>
      <h2>Grafgegevens</h2>
      <p><strong>Naam:</strong> {selectedPlaats.naam}</p>
      <p><strong>Grafnummer:</strong> {selectedPlaats.id}</p>
      <p><strong>Locatie:</strong> {selectedPlaats.locatie}</p>

      <button class="close-btn" on:click={closeModal}>Sluiten</button>
    </div>
  </div>
{/if}

<style>
  /* Container */
  .container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 2rem;
    font-family: sans-serif;
  }

  h1 {
    text-align: center;
    font-size: 1.8rem;
    margin-bottom: 1.5rem;
  }

  /* Zoekbalk */
  .search-container {
    margin-bottom: 1rem;
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
  }

  .search-container input {
    flex: 1;
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    min-width: 200px;
  }

  .search-container button {
    padding: 0.5rem 1rem;
    border: none;
    background: rgb(59, 57, 57);
    color: white;
    border-radius: 4px;
    cursor: pointer;
  }

  .search-container button:hover {
    background: rgb(80, 78, 78);
  }

  /* ✅ Responsive grid */
  .cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
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

  .details-btn:hover {
    background: rgb(80, 78, 78);
  }

  .pagination {
    margin-top: 1rem;
    display: flex;
    gap: 0.5rem;
    justify-content: center;
  }

  /* ✅ Modal styling */
  .modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 50;
    animation: fadeIn 0.2s ease;
  }

  .modal {
    background: white;
    padding: 1.5rem;
    border-radius: 10px;
    width: 90%;
    max-width: 400px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    animation: slideUp 0.25s ease;
  }

  .modal h2 {
    margin-bottom: 1rem;
  }

  .modal p {
    margin-bottom: 0.5rem;
  }

  .close-btn {
    background: rgb(59, 57, 57);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 1rem;
  }

  .close-btn:hover {
    background: rgb(80, 78, 78);
  }

  /* ✅ Animations */
  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }

  @keyframes slideUp {
    from { transform: translateY(20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
  }

  /* ✅ Mobile friendly tweaks */
  @media (max-width: 600px) {
    h1 {
      font-size: 1.4rem;
    }

    .search-container {
      flex-direction: column;
    }

    .search-container button {
      width: 100%;
    }

    .card-content h2 {
      font-size: 1rem;
    }
  }
</style>
