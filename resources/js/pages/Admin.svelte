<script>
  import { onMount } from "svelte";

  export let page = "Admin Overzicht";
  let searchTerm = "";
  let grafData = [];

  let showModal = false;
  let showDeleteModal = false;
  let selectedPlaats = null;
  let deleteId = null;
  let deleteName = "";
  let errorMessage = "";

  onMount(async () => {
    try {
      const res = await fetch("/users", { credentials: "include" }); // send session cookies
      if (!res.ok) throw new Error("Kan gebruikers niet laden");

      const data = await res.json();
      grafData = data.map(user => ({
        id: user.id,
        naam: user.name,
        locatie: ""
      }));
    } catch (err) {
      console.error(err);
      showError("Fout bij laden van gegevens.");
    }
  });

  // Dynamically filter users
  $: filteredGrafData = grafData.filter(plaats =>
    plaats.naam.toLowerCase().includes(searchTerm.toLowerCase())
  );

  function openModal(plaats) {
    selectedPlaats = plaats;
    showModal = true;
  }
  function closeModal() {
    showModal = false;
    selectedPlaats = null;
  }
  function confirmDelete(plaats) {
    deleteId = plaats.id;
    deleteName = plaats.naam;
    showDeleteModal = true;
  }
  function cancelDelete() {
    showDeleteModal = false;
    deleteId = null;
    deleteName = "";
  }

  function showError(msg) {
    errorMessage = msg;
    setTimeout(() => (errorMessage = ""), 3000);
  }

  async function deleteGraf() {
    try {
      const res = await fetch(`/users/${deleteId}`, {
        method: "DELETE",
        headers: {
          "Content-Type": "application/json"
        },
        credentials: "include" // session-based authentication
      });

      if (res.ok) {
        grafData = grafData.filter(p => p.id !== deleteId);
        cancelDelete();
      } else {
        const errData = await res.json();
        showError(errData.message || "Verwijderen mislukt.");
      }
    } catch (err) {
      console.error(err);
      showError("Serverfout bij verwijderen.");
    }
  }
</script>

<div class="container">
  <h1>{page}</h1>

  <div class="search-container">
    <input type="text" bind:value={searchTerm} placeholder="Zoeken op naam..." />
  </div>

  <div class="cards-grid">
    {#each filteredGrafData as plaats}
      <div class="card">
        <div class="image-placeholder"></div>
        <div class="card-content">
          <h2>Gebruiker</h2>
          <p><strong>Naam:</strong> {plaats.naam}</p>
          <p><strong>ID:</strong> {plaats.id}</p>
          <p><strong>Locatie:</strong> {plaats.locatie || "—"}</p> 
        </div>
        <div class="button-row">
          <button class="details-btn" on:click={() => openModal(plaats)}>
            Bekijk gegevens
          </button>
          <button class="delete-btn" on:click={() => confirmDelete(plaats)} title="Verwijderen">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="white" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" class="trash-icon">
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

  {#if errorMessage}
    <div class="error-toast fade-in">{errorMessage}</div>
  {/if}
</div>

{#if showModal}
  <div class="modal-backdrop" on:click={closeModal}>
    <div class="modal fade-in" on:click|stopPropagation>
      <h2>Gebruiker</h2>
      <p><strong>Naam:</strong> {selectedPlaats.naam}</p>
      <p><strong>ID:</strong> {selectedPlaats.id}</p>
      <p><strong>Locatie:</strong> {selectedPlaats.locatie || "—"}</p>
      <button class="close-btn" on:click={closeModal}>Sluiten</button>
    </div>
  </div>
{/if}

{#if showDeleteModal}
  <div class="modal-backdrop" on:click={cancelDelete}>
    <div class="delete-modal fade-in" on:click|stopPropagation>
      <h3>Weet je het zeker?</h3>
      <p>Weet je zeker dat je <strong>{deleteName}</strong> wilt verwijderen?</p>
      <div class="delete-buttons">
        <button class="cancel" on:click={cancelDelete}>Annuleren</button>
        <button class="confirm" on:click={deleteGraf}>Verwijderen</button>
      </div>
    </div>
  </div>
{/if}
