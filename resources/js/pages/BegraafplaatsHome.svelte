<script>
    export let begraafplaats;
  </script>
  
  <div class="container">
    <!-- Hero sectie -->
    <div class="hero">
      <h1>{begraafplaats.titel}</h1>
      <p>{begraafplaats.omschrijving}</p>
    </div>
  
    <!-- Over begraafplaats sectie -->
    <section class="over">
      <h2>Over begraafplaats</h2>
      <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
        Suspendisse vitae magna nec justo imperdiet gravida. 
        Vivamus eget nisl at est iaculis feugiat.
      </p>
      <p>
        Curabitur ullamcorper, velit non sodales dictum, ipsum libero laoreet nisi, 
        vel lacinia orci arcu at mauris.
      </p>
    </section>
  </div>
  
  <style>
  .container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 2rem;
    font-family: sans-serif;
  }
  
  .hero {
    text-align: center;
    padding: 3rem 2rem;
    background: #f3f4f6;
    border-radius: 12px;
    margin-bottom: 2rem;
  }
  
  .hero h1 {
    font-size: 2rem;
    margin-bottom: 1rem;
  }
  
  .hero p {
    font-size: 1.1rem;
    color: #555;
    margin-bottom: 1.5rem;
  }
  
  .cta-btn {
    padding: 0.75rem 1.5rem;
    background: #333;
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
  }
  
  .over h2 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
  }
  
  .over p {
    margin-bottom: 1rem;
    line-height: 1.6;
  }
  </style>
  