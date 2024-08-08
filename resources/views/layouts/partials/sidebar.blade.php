<div class="container-menu">
  @foreach ($panels as $panelIndex => $panel)
  <div class="subtitle-menus">{{ $panel['group'] }}</div>
  <div class="collapse-container">
    @foreach ($panel['menus'] as $menuIndex => $menu)
    <input type="checkbox" id="collapse-toggle-{{ $panelIndex }}-{{ $menuIndex }}" class="collapse-toggle">
    @if (!empty($menu['submenus']))
    <label for="collapse-toggle-{{ $panelIndex }}-{{ $menuIndex }}" class="collapse-label">
      <div>
        @svg($menu['icon'], 'menu-icon-options')
        <span style="margin-left: 8px;">{{ $menu['name'] }}</span>
      </div>
      @svg('eva-arrow-ios-back', 'arrow-icon')
    </label>

    <div class="collapse-content">
      @foreach ($menu['submenus'] as $submenuIndex => $submenu)
      <a href="{{ route($submenu['path']) }}" class="collapse-option o8f95" 
      data-path="{{ route($submenu['path']) }}">
        <div>
          @svg($submenu['icon'], 'menu-icon-options ' . $submenu['icon'])
          <span style="margin-left: 8px;">{{ $submenu['name'] }}</span>
        </div>
      </a>
      @endforeach
    </div>
    @else
    <label for="collapse-toggle-{{ $panelIndex }}-{{ $menuIndex }}" class="collapse-label" onclick="window.location.href = '{{ route($menu['path']) }}'">
      <a class="o8f95" data-path="{{ route($menu['path']) }}">
        <div>
          @svg($menu['icon'], 'menu-icon-options')
          <span style="margin-left: 8px;">{{ $menu['name'] }}</span>
        </div>
      </a>
    </label>
    @endif
    @endforeach
  </div>
  @endforeach
</div>

<script defer>
document.addEventListener('DOMContentLoaded', function() {
    const containerMenu = $('.container-menu');
    const titleMenu = $('#title-menu-o8f95');

    if (containerMenu) {
      containerMenu.addEventListener('change', function(event) {
        if (event.target.classList.contains('collapse-toggle')) {
          $$('.collapse-toggle').forEach(toggle => {
            if (toggle !== event.target) {
              toggle.checked = false;
            }
          });
        }
      });

      // Activa los elementos basados en la URL
      const currentPath = window.location.href;

      $$('.collapse-option').forEach(option => {
        const path = option.getAttribute('data-path');
        if (path && currentPath === path) {
          let newTitle = option.getElementsByTagName('div')[0].getElementsByTagName('span')[0].innerText
          if(titleMenu){
            titleMenu.innerText = newTitle;
            console.log(newTitle)
          }
          option.closest('.collapse-content').previousElementSibling.click();
          option.classList.add('active');
        }
      });

      document.querySelectorAll('.collapse-label > a').forEach(option => {
        const path = option.getAttribute('data-path');
  
        if (path && currentPath === path) {
          let newTitle = option.getElementsByTagName('div')[0].getElementsByTagName('span')[0].innerText
          if(titleMenu){
            titleMenu.innerText = newTitle;
            console.log(newTitle)
          }
          option.closest('.collapse-label').classList.add('active');
        }
      });
    }
  });
</script>

<style>
  .container-menu {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    padding-inline: 0.5rem;
    padding-bottom: 20px;
  }

  .subtitle-menus {
    color: var(--txt-color);
    font-weight: 400;
    font-size: 0.8125rem;
    /* 13px */
    margin-block: 0.5rem;
  }

  .collapse-container {
    width: 100%;
  }

  .collapse-toggle {
    display: none;
  }

  .collapse-label {
    display: flex;
    justify-content: space-between;
    padding: 0.625rem;
    /* 10px */
    background: var(--bg-color);
    color: var(--txt-light-color);
    cursor: pointer;
    border-radius: 0.4375rem;
    /* 7px */
    margin-bottom: 0.5rem;
    /* 2px */
    transition: background 0.3s ease;
  }

  .collapse-label:hover,
  .collapse-toggle:checked+.collapse-label {
    background: var(--op-color);
  }

  .collapse-toggle:checked+.collapse-label .arrow-icon {
    transform: rotate(-90deg);
  }

  .collapse-content {
    /* margin-left: 0px; */
    max-height: 0;
    overflow: auto;
    transition: max-height 0.5s ease-out;
  }

  .collapse-toggle:checked+.collapse-label+.collapse-content {
    max-height: 220px;
  }

  .collapse-option,
  .collapse-option-main {
    display: block;
    padding: 0.625rem;
    background: var(--bg-color);
    text-decoration: none;
    color: var(--txt-color);
    border-radius: 0.4375rem;
    margin-bottom: 0.5rem;
    transition: background 0.3s ease;
  }

  .collapse-option-main {
    color: #fff;
  }

  .collapse-option:hover,
  .collapse-option:focus,
  .collapse-option-main:hover,
  .collapse-option-main:focus {
    filter: brightness(2);
  }

  .arrow-icon,
  .menu-icon-options {
    width: 1.2rem;
    transition: transform 0.4s ease-out;
  }

  .collapse-label.active{
    background: var(--op-color);
    color: var(--txt-light-color);
  }

  .collapse-option.active {
    filter: brightness(.6);
  }

  .collapse-label.active .arrow-icon {
    transform: rotate(-90deg);
  }
</style>