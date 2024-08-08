<div class="menu-profile">
  <img 
  class="img-profile"
  src="{{ $data['profileurl'] }}" alt="profile.img">
  <a href="#" class="label-profile">{{ $data['profilename'] }}</a>
</div>


<style>
  .menu-profile {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    padding-block: 10px;
    margin-inline: 8px;
    border-bottom: 1px solid var(--txt-dark-color);
  }

  .img-profile {
    width: 2.5rem;
    height: 2.5rem;
    object-fit: cover;
    margin-left: 10px;
    border-radius: 100%;
    /* filter: grayscale(1); */
  }

  .label-profile {
    text-decoration: none;
    font-size: 1rem;
    font-weight: 400;
    color: var(--txt-color);
    margin-left: 10px;
  }

  .label-profile:hover {
    filter: brightness(1.5);
  }
</style>