<style>
    /* Tooltip container */
    .tooltip {
    position: relative;
    display: inline-block;
    color: #000000;
    }

    /* Tooltip text */
    .tooltip .tooltiptext {
    visibility: hidden;
    width: 120px;
    background-color: #ffffff;
    color: #000;
    border: 2px solid #d7d7d7;
    text-align: center;
    padding: 5px 0;
    border-radius: 6px;

    /* Position the tooltip text */
    position: absolute;
    z-index: 1;
    bottom: 125%;
    left: 50%;
    margin-left: -60px;

    /* Fade in tooltip */
    opacity: 0;
    transition: opacity 0.3s;
    }

    .tooltip:hover .tooltiptext {
    visibility: visible;
    opacity: 1;
    }
</style>

<div class="tooltip">*
  <span class="tooltiptext">Dit veld is verplicht</span>
</div>