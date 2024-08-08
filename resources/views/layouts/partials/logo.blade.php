<div class="logo-container">
  <img 
    class="img-logo"
    src="{{ $data['logourl'] }}" alt="logo">
</div>

<style>
  .logo-container {
    display: flex;
    justify-content: center;
    align-items: center;
    border-bottom: 1px solid var(--txt-dark-color);
  }

  .img-logo {
    width: 100%;
    height: 4rem;
    margin: 8px;
    object-fit: contain;
    border-radius: 50px;
    /* filter: grayscale(1); */
    filter: brightness(0) saturate(100%) invert(87%) sepia(0%) saturate(1742%) hue-rotate(147deg) brightness(87%) contrast(117%);
  }
</style>