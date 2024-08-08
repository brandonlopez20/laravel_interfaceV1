<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@yield('title', 'Default Title')</title>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<script>
	const $ = e => document.querySelector(e);
	const $$ = e => document.querySelectorAll(e);

	function useCustomState(initialValue) {
		let state = initialValue;
		const listeners = new Set();

		const getState = () => state;

		const setState = (newValue) => {
			const nextState = typeof newValue === 'function' ? newValue(state) : newValue;

			if (!Object.is(state, nextState)) {
				state = nextState;
				notifyListeners();
			}
		};

		const subscribe = (listener) => {
			listeners.add(listener);
			return () => listeners.delete(listener);
		};

		const notifyListeners = () => {
			listeners.forEach(listener => listener(state));
		};

		return [getState, setState, subscribe];
	}



	function adjustColor(hex, percentLighter, percentDarker) {
		// Eliminar el símbolo '#' si está presente
		hex = hex.replace(/^#/, '');
		if (hex.length === 3) {
			hex = hex.split('').map(x => x + x).join('');
		}

		// Convertir hexadecimal a RGB
		const r = parseInt(hex.substring(0, 2), 16);
		const g = parseInt(hex.substring(2, 4), 16);
		const b = parseInt(hex.substring(4, 6), 16);

		// Ajustar el color
		const adjust = (color, percent) => Math.min(255, Math.max(0, color + (color * percent)));

		// Calcular el color más claro
		const rLighter = Math.round(adjust(r, percentLighter));
		const gLighter = Math.round(adjust(g, percentLighter));
		const bLighter = Math.round(adjust(b, percentLighter));

		// Calcular el color más oscuro
		const rDarker = Math.round(adjust(r, percentDarker));
		const gDarker = Math.round(adjust(g, percentDarker));
		const bDarker = Math.round(adjust(b, percentDarker));

		// Convertir RGB de vuelta a hexadecimal
		const toHex = (color) => color.toString(16).padStart(2, '0');

		return {
			lighter: `#${toHex(rLighter)}${toHex(gLighter)}${toHex(bLighter)}`,
			darker: `#${toHex(rDarker)}${toHex(gDarker)}${toHex(bDarker)}`
		};
	}

	const result = adjustColor("{{ $data['textcolor'] }}", 0.5, -0.5);
	console.log(result.lighter); // #e6e6e6 (20% más claro)
	console.log(result.darker); // #999999 (20% más oscuro)

const root = document.documentElement; // Esto selecciona el elemento <html>
root.style.setProperty('--txt-color', "{{ $data['textcolor'] }}");
root.style.setProperty('--txt-dark-color', result.darker);
root.style.setProperty('--txt-light-color', result.lighter);
root.style.setProperty('--op-color', "{{ $data['hovercolor'] }}");
root.style.setProperty('--bg-color', "{{ $data['bgcolor'] }}");
console.log("{{ $data['bgcolor'] }}")
</script>

<body>
	<div>
		<!-- Overlay Wrapper -->
		<div class="wrapper" id="wrapper"></div>

		<!-- SideBar -->
		<aside class="sidebar" id="sidebar">
			@if ($data['showlogo'])
			@include('layouts.partials.logo')
			@endif
			@if ($data['showprofile'])
			@include('layouts.partials.profile')
			@endif
			@if ($data['showinput'])
			@include('layouts.partials.inputSearch')
			@endif
			<div class="container-menu-main" id="container-menu-main">
				@include('layouts.partials.sidebar')
			</div>
		</aside>

		<!-- NavBar -->

		<nav class="navbar" id="navbar">
			@include('layouts.partials.navbar')
		</nav>


		<!-- Content -->
		<div class="content" id="content">
			<div class="content-container" id="content-container">
				<div class="content-mt">
					<div class="content-prube">
						@yield('content')
					</div>

				</div>

			</div>
		</div>
</body>
<script>
	const sidebar = $("#sidebar");
	const navcontainerbar = $("#nav-container");
	const navbtnscontainerbar = $("#nav-btns-container");
	const wrapper = $("#wrapper");
	const menuIcon = $("#menu-icon");
	const content = $("#content-container");

	const [WScreen, setWScreen] = useCustomState(window.innerWidth);
	const defaultSize = 986;
	const [getToggle, setToggle, subToggle] = useCustomState(
		WScreen() <= defaultSize
	);

	window.addEventListener("resize", () => {
		const newWidth = window.innerWidth;
		const newToggle = newWidth >= defaultSize;

		if (newToggle) {
			if (WScreen() < newWidth) {
				sidebar.style.boxShadow =
					"0px 17px 30px rgba(163, 126, 198, 0.502)";
				sidebar.style.transform = "translateX(0)";
				navcontainerbar.style.transform = "translateX(15.5rem)";
				navbtnscontainerbar.style.transform = "translateX(-15.5rem)";

				content.style.transform = "translateX(15.5rem)";
				content.style.width = "calc(100% - 15.5rem)"

				wrapper.style.display = "none";
				setToggle(true);
			}
		} else {
			if (WScreen() > newWidth) {
				if (getToggle()) {
					sidebar.style.transform = "translateX(-100%)";
					sidebar.style.boxShadow = "none";
					navcontainerbar.style.transform = "translateX(0)";
					navbtnscontainerbar.style.transform = "translateX(0)";

					content.style.transform = "translateX(0)";
					content.style.width = "100%";

					wrapper.style.display = "none";
					setToggle(false);
				}
			}
		}

		return setWScreen(newWidth);
	});

	subToggle((newState) => {
		// console.log(newState);
	});

	[menuIcon, wrapper].forEach((el) =>
		el.addEventListener("click", () => {
			if (WScreen() <= defaultSize) {
				updateMobileVisibility();
			} else {
				updateDesktopVisibility();
			}
		})
	);

	function updateMobileVisibility() {
		if (getToggle()) {
			sidebar.style.transform = "translateX(-100%)";
			sidebar.style.boxShadow = "none";
			navcontainerbar.style.transform = "translateX(0)";
			navbtnscontainerbar.style.transform = "translateX(0)";

			content.style.transform = "translateX(0)";
			content.style.width = "100%";

			wrapper.style.display = "none";
			setToggle(false);
		} else {
			sidebar.style.boxShadow = "0px 17px 30px rgba(163, 126, 198, 0.502)";
			sidebar.style.transform = "translateX(0)";
			navcontainerbar.style.transform = "translateX(0)";
			navbtnscontainerbar.style.transform = "translateX(0)";

			content.style.transform = "translateX(0)";
			content.style.width = "100%";

			wrapper.style.display = "block";
			setToggle(true);
		}
	}

	function updateDesktopVisibility() {
		if (!getToggle()) {
			sidebar.style.boxShadow = "0px 17px 30px rgba(163, 126, 198, 0.502)";
			sidebar.style.transform = "translateX(0)";
			navcontainerbar.style.transform = "translateX(15.5rem)";
			navbtnscontainerbar.style.transform = "translateX(-15.5rem)";

			content.style.transform = "translateX(15.5rem)";
			content.style.width = "calc(100% - 15.5rem)"

			setToggle(true);
		} else {
			sidebar.style.boxShadow = "none";
			sidebar.style.transform = "translateX(-100%)";
			navcontainerbar.style.transform = "translateX(0)";
			navbtnscontainerbar.style.transform = "translateX(0)";

			content.style.transform = "translateX(0)";
			content.style.width = "100%";

			setToggle(false);
		}
	}

	if (getToggle()) {
		updateMobileVisibility();
	} else {
		updateDesktopVisibility();
	}
</script>

<style>
	body {
		font-family: "Roboto", sans-serif;
		box-sizing: border-box;
		margin: 0;
		padding: 0;
		user-select: none;
	}

	:root {
		--bg-color: #dc3545;
		--txt-color: #c2a006;
		--txt-dark-color: #000;
		--txt-light-color: #fff;
		/* --op-color: #0d6efd; */
		--op-color: #000;
	}

	.sidebar {
		position: fixed;
		top: 0;
		left: 0;
		z-index: 1000;
		height: 100%;
		width: 15.5rem;
		transition: transform 0.3s ease;
		/* Habilita el scroll vertical */
		background: var(--bg-color);
		box-shadow: 0px 17px 30px rgba(163, 126, 198, 0.502);
	}

	.container-menu-main {
		overflow-y: auto;
		height: 100%;
	}



	.navbar {
		position: fixed;
		left: 0;
		top: 0;
		height: 3.5rem;
		width: 100%;
		z-index: 900;
		background: var(--bg-color);
		/* color: var(--txt-color); */
		display: flex;
		align-items: center;
		box-shadow: 4px 4px 8px rgba(163, 126, 198, 0.502);
	}

	.content {
		position: relative;
		z-index: 800;
		left: 0;
		top: 3.5rem;
		width: 100%;
	}

	@media (max-width: 986px) {
		.sidebar {
			transform: translateX(-100%);
			box-shadow: none;
		}

		.wrapper {
			display: none;
			position: fixed;
			top: 0;
			left: 0;
			z-index: 950;
			width: 100%;
			height: 100%;
			background: rgba(0, 0, 0, 0.2);
		}
	}

	.collapse-content::-webkit-scrollbar,
	.options-search::-webkit-scrollbar,
	.container-menu-main::-webkit-scrollbar {
		width: 5px;
		/* Ancho de la barra de scroll */
		background-color: transparent;
		/* Color de fondo transparente */
	}

	.collapse-content::-webkit-scrollbar-thumb,
	.options-search::-webkit-scrollbar-thumb,
	.container-menu-main::-webkit-scrollbar-thumb {
		background-color: var(--txt-color);
		/* Color de la barra de scroll */
		border-radius: 10px;
		/* Borde redondeado */
		-webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
		/* Sombra interna */
	}

	.collapse-content::-webkit-scrollbar-thumb:hover,
	.options-search::-webkit-scrollbar-thumb:hover,
	.container-menu-main::-webkit-scrollbar-thumb:hover {
		background-color: var(--txt-dark-color);
	}

	.collapse-content::-webkit-scrollbar-corner,
	.options-search::-webkit-scrollbar-corner,
	.container-menu-main::-webkit-scrollbar-corner {
		background-color: transparent;
		/* Color de fondo transparente para la esquina */
	}

	.collapse-content::-webkit-scrollbar-button,
	.options-search::-webkit-scrollbar-button,
	.container-menu-main::-webkit-scrollbar-button {
		display: none;
		/* Ocultar las flechas de arriba y abajo */
	}

	.content-container {
		margin-top: -1.5rem;
		width: 100%;
		transform: translateX(15.5rem);
		transition: transform .3s ease, width .3s ease;
	}

	.content-mt {
		margin-top: 1.5rem;
		width: 100%;
	}

	.content-prube {
		height: 100vh;
		width: 100%;
		color: #fff;
		background: #5f5c5c;
	}
</style>

</html>