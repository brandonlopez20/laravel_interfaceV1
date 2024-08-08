<div class="nav-container" id="nav-container">
	<div class="nav-btn-container">
		<button id="menu-icon">
			@svg('vaadin-menu')
		</button>
		@if($data['showtitle'])
		<p class="title-menu" id="title-menu-o8f95">Home</p>
		@endif
	</div>

	<div class="nav-btns-container" id="nav-btns-container">

		@if ($data['buttonconfig'])
		<button class="btn-menu-icon" id="btn-menu-config">
			@svg('eva-settings-2-outline')
			<span class="tooltip">Settings</span>
		</button>
		@endif
		@if ($data['buttontheme'])
		<button class="btn-menu-icon" id="theme-btn-menu-icon" onclick="toggleTheme()">
			<x-eva-moon-outline id="theme-svg-moon-icon" style="display:none;" />
			<x-eva-sun id="theme-svg-sun-icon" style="display:block;" />
			<span class="tooltip">Theme Ligth</span>
		</button>
		@endif

		@foreach ($data['options'] as $option)
		<button class="btn-menu-icon" id="{{ $option['id'] }}">
			@svg($option['icon'])
			<span class="tooltip">{{ $option['span'] }}</span>
			@if ($option['value'])
			<span class="badge">{{ $option['value'] }}</span>
			@endif
		</button>
		@endforeach
	</div>
</div>

<script>
	// Obtener elementos
	const btnTheme = document.querySelector('#theme-btn-menu-icon');
	const svgDark = document.querySelector('#theme-svg-moon-icon');
	const svgLight = document.querySelector('#theme-svg-sun-icon');
	const currentTheme = localStorage.getItem('theme') || 'Light';

	function applyTheme(theme) {
		document.body.className = theme === 'Dark' ? 'dark-theme' : 'light-theme';
		svgDark.style.display = theme === 'Dark' ? 'block' : 'none';
		svgLight.style.display = theme === 'Light' ? 'block' : 'none';
		if (btnTheme) btnTheme.querySelector('span').textContent = theme;
	}
	function toggleTheme() {
		const newTheme = localStorage.getItem('theme') === 'Light' ? 'Dark' : 'Light';
		localStorage.setItem('theme', newTheme);
		applyTheme(newTheme);
	}

	if(btnTheme){
		applyTheme(currentTheme);

	}
</script>


<style>
	#menu-icon,
	.btn-menu-icon {
		all: unset;
		cursor: pointer;
		position: relative;
		display: inline-block;
	}

	#menu-icon:active svg,
	.btn-menu-icon:active svg {
		transform: scale(0.8);
		transition: transform 0.2s ease-in-out;
	}

	#menu-icon:hover svg,
	.btn-menu-icon:hover svg {
		filter: brightness(1.5);
	}

	.btn-menu-icon {
		padding-inline: 13px;
	}

	#menu-icon svg {
		width: 1rem;
		color: var(--txt-color);
	}

	.btn-menu-icon svg {
		width: 1.3rem;
		color: var(--txt-color);
	}

	.title-menu {
		color: var(--txt-color);
		font-size: 16px;
		line-height: 1.2;
		font-weight: 600;
	}

	.nav-container {
		display: flex;
		justify-content: space-between;
		align-items: center;
		width: 100%;
		transform: translateX(15.5rem);
		transition: transform .3s ease;
	}

	.nav-btn-container {
		display: flex;
		align-items: center;
		padding-left: 10px;
		gap: 1rem;
	}

	.nav-btns-container {
		display: flex;
		padding-inline: 10px;
		flex-direction: row-reverse;
		transform: translateX(-15.5rem);
		transition: transform .3s ease;
	}

	@media (max-width: 986px) {

		.nav-btns-container,
		.nav-container {
			transform: translateX(0);
		}

		.title-menu {
			display: none;
		}


	}

	.tooltip {
		visibility: hidden;
		background-color: rgba(95, 92, 92, .7);
		color: #fff;
		text-align: center;
		border-radius: 5px;
		padding: 5px 10px;
		position: absolute;
		z-index: 1;
		top: 125%;
		left: 50%;
		transform: translateX(-50%);
		opacity: 0;
		transition: opacity 0.3s, top 0.3s;
		font-size: 12px;
		white-space: nowrap;
	}

	.btn-menu-icon:hover .tooltip {
		visibility: visible;
		opacity: 1;
		top: 110%;
	}

	.badge {
		position: absolute;
		top: -12px;
		right: -10px;
		padding: 4px 8px;
		border-radius: 12px;
		background-color: rgba(255, 0, 0, .8);
		color: white;
		font-size: 0.75rem;
		line-height: 1;
		white-space: nowrap;
	}
</style>