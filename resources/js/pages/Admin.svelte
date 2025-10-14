
<script>
  import { onMount } from "svelte";
  import "../../css/admin.css";
  export let page = "Admin Overzicht";
  let searchTerm = "";
  let grafData = [];

  // Popup states
  let showModal = false;
  let showDeleteModal = false;
  let selectedPlaats = null;
  let deleteId = null;

  // Error melding
  let errorMessage = "";

  // ✅ Data ophalen
  onMount(async () => {
    try {
      const res = await fetch("/users");
      const data = await res.json();

      grafData = data.map((user) => ({
        id: user.id,
        naam: user.name,
        locatie: user.email
      }));
    } catch (err) {
      showError("Fout bij laden van gegevens.");
    }
  });

  // ✅ Filter
  $: filteredGrafData = grafData.filter(
    (plaats) =>
      plaats.naam.toLowerCase().includes(searchTerm.toLowerCase()) ||
      plaats.locatie.toLowerCase().includes(searchTerm.toLowerCase())
  );

  // ✅ Modals openen/sluiten
  function openModal(plaats) {
    selectedPlaats = plaats;
    showModal = true;
  }

  function closeModal() {
    showModal = false;
    selectedPlaats = null;
  }

  function confirmDelete(id) {
    deleteId = id;
    showDeleteModal = true;
  }

  function cancelDelete() {
    showDeleteModal = false;
    deleteId = null;
  }

  // ✅ Custom error melding
  function showError(msg) {
    errorMessage = msg;
    setTimeout(() => {
      errorMessage = "";
    }, 3000); // verdwijnt na 3 seconden
  }

  // ✅ Verwijderen
  async function deleteGraf() {
    try {
      const res = await fetch(`/users/${deleteId}`, { method: "DELETE" });
      if (res.ok) {
        grafData = grafData.filter((plaats) => plaats.id !== deleteId);
        showDeleteModal = false;
      } else {
        showError("❌ Verwijderen mislukt. Probeer opnieuw.");
      }
    } catch (err) {
      console.error(err);
      showError("❌ Serverfout bij verwijderen.");
    }
  }
</script>

<!-- 🧱 Layout -->
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
          <p><strong>Locatie:</strong> {plaats.locatie}</p>
        </div>

        <div class="button-row">
          <button class="details-btn" on:click={() => openModal(plaats)}>
            Bekijk gegevens
          </button>

          <button
            class="delete-btn"
            on:click={() => confirmDelete(plaats.id)}
            title="Verwijderen"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              stroke="white"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              viewBox="0 0 24 24"
              class="trash-icon"
            >
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

  <!-- 🔴 Error melding -->
  {#if errorMessage}
    <div class="error-toast fade-in">{errorMessage}</div>
  {/if}
</div>

<!-- 📋 Detail Modal -->
{#if showModal}
  <div class="modal-backdrop" on:click={closeModal}>
    <div class="modal fade-in" on:click|stopPropagation>
      <h2>Grafgegevens</h2>
      <p><strong>Naam:</strong> {selectedPlaats.naam}</p>
      <p><strong>Grafnummer:</strong> {selectedPlaats.id}</p>
      <p><strong>Locatie:</strong> {selectedPlaats.locatie}</p>
      <button class="close-btn" on:click={closeModal}>Sluiten</button>
    </div>
  </div>
{/if}

<!-- 🗑️ Delete Confirm Modal -->
{#if showDeleteModal}
  <div class="modal-backdrop" on:click={cancelDelete}>
    <div class="delete-modal fade-in" on:click|stopPropagation>
      <h3>Weet je het zeker?</h3>
      <p>Weet je zeker dat je dit item wilt verwijderen?</p>
      <div class="delete-buttons">
        <button class="cancel" on:click={cancelDelete}>Annuleren</button>
        <button class="confirm" on:click={deleteGraf}>Verwijderen</button>
      </div>
    </div>
  </div>
{/if}

