<script>
  export let page = "Admin Overzicht";

  
  let searchTerm = "";

  
  let grafData = [
    { id: 1, naam: "Jan Jansen", locatie: "Rotterdam" },
    { id: 2, naam: "Piet Pietersen", locatie: "Utrecht" },
    { id: 3, naam: "Anna de Vries", locatie: "Amsterdam" },
    { id: 4, naam: "Karel van Dijk", locatie: "Den Haag" },
    { id: 5, naam: "Sofie Bakker", locatie: "Leiden" },
    { id: 6, naam: "Lars Visser", locatie: "Groningen" }
  ];

  
  let showModal = false;
  let selectedPlaats = null;


  $: filteredGrafData = grafData.filter((plaats) =>
    plaats.naam.toLowerCase().includes(searchTerm.toLowerCase()) ||
    plaats.locatie.toLowerCase().includes(searchTerm.toLowerCase())
  );


  function openModal(plaats) {
    selectedPlaats = plaats;
    showModal = true;
  }

  
  function closeModal() {
    showModal = false;
    selectedPlaats = null;
  }

  
  function deleteGraf(id) {
    if (confirm("Weet je zeker dat je dit graf wilt verwijderen?")) {
      grafData = grafData.filter((plaats) => plaats.id !== id);
    }
  }
</script>


<div class="container">
  <h1>{page}</h1>


  <div class="search-container">
    <input type="text" bind:value={searchTerm} placeholder="Zoeken..." />
  </div>

 
  <div class="cards-grid">
    {#each filteredGrafData as plaats}
      <div class="card">
        <div class="image-placeholder"></div>

        <div class="card-content">
          <h2>Grafgegevens</h2>
          <p><strong>Naam:</strong> {plaats.naam}</p>
          <p><strong>Grafnummer:</strong> {plaats.id}</p>
          <p>📍 {plaats.locatie}</p>
        </div>

        
        <div class="button-row">
          <button class="details-btn" on:click={() => openModal(plaats)}>
            Bekijk gegevens
          </button>

          <button class="delete-btn" on:click={() => deleteGraf(plaats.id)} title="Verwijderen">
    
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              viewBox="0 0 24 24" class="trash-icon">
              <polyline points="3 6 5 6 21 6"></polyline>
              <path d="M19 6l-1 14H6L5 6m5 0V4h4v2"></path>
            </svg>
          </button>
        </div>
      </div>
    {/each}
  </div>

  {#if filteredGrafData.length === 0}
    <p class="no-results">Geen resultaten gevonden.</p>
  {/if}
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

  .search-container {
    margin-bottom: 1rem;
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
  }

  .search-container input {
    flex: 1;
    padding: 0.6rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    min-width: 200px;
  }

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
    height: 160px;
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

  .button-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 1rem 1rem;
  }

  .details-btn {
    flex: 1;
    padding: 0.5rem;
    border: none;
    background: rgb(59, 57, 57);
    color: white;
    border-radius: 4px;
    cursor: pointer;
    margin-right: 0.5rem;
  }

  .details-btn:hover {
    background: rgb(80, 78, 78);
  }

  .delete-btn {
    background: #dc2626;
    border: none;
    border-radius: 6px;
    padding: 0.45rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
  }

  .delete-btn:hover {
    background: #b91c1c;
  }

  .trash-icon {
    width: 20px;
    height: 20px;
    stroke: white;
  }

  .no-results {
    text-align: center;
    margin-top: 2rem;
    color: #555;
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
  }

  .modal {
    background: white;
    padding: 1.5rem;
    border-radius: 10px;
    width: 90%;
    max-width: 400px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
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

  /* ✅ Responsive tweaks */
  @media (max-width: 600px) {
    h1 {
      font-size: 1.4rem;
    }

    .search-container {
      flex-direction: column;
    }

    .details-btn {
      font-size: 0.9rem;
    }
  }
</style>
