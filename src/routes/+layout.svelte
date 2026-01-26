<script>
    import { onMount } from 'svelte';
    // Import $page för att komma åt datan som skickades från +layout.server.js
    import { page } from '$app/stores'; 
    import { exerciseData } from '$lib/stores/exerciseStore'; 
    
    import tugnIcon from '$lib/assets/tugnIcon.png';
    import Header from "$lib/components/Header.svelte";
    import "$lib/global.scss";

    // data som du skickade från servern ligger nu i $page.data.apiData
    
    let { children } = $props();

    onMount(() => {
        // Kontrollera att data finns i $page.data och att store:et är tomt
        if ($page.data.apiData && $exerciseData === null) {
            console.log('Client: Caching exercise API data into global store.');
            
            // Lagra datan från $page.data.apiData i ditt globala store
            exerciseData.set($page.data.apiData);

		
        }
    });


</script>

<svelte:head>
    <link rel="icon" href={tugnIcon} />
</svelte:head>
<Header />
{@render children?.()}