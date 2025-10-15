<script>
	import tugnIcon from '$lib/assets/tugnIcon.png';
	import Header from "$lib/components/Header.svelte";
	import "$lib/global.scss";

	let { children } = $props();
</script>

<svelte:head>
	<link rel="icon" href={tugnIcon} />
</svelte:head>
<Header />
{@render children?.()}
