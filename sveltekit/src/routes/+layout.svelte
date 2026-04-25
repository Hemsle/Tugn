<script>
    import { page } from "$app/stores";
    import tugnIcon from "$lib/assets/tugnIcon.png";
    import Header from "$lib/components/Header.svelte";
    import "$lib/global.scss";

    let { children } = $props();
</script>

<svelte:head>
    <link rel="icon" href={tugnIcon} />
</svelte:head>

 
<div class="app-container">
    {#if $page.url.pathname !== "/login" && $page.url.pathname !== "/login/register"}
        <aside>
            <Header />
        </aside>
    {/if}

    <div id="box">
        {@render children?.()}
    </div>
</div>

<style lang="scss">
    .app-container {
        display: flex;
        min-height: 100vh;

        aside {
            width: 22rem;
            flex-shrink: 0;
        }
    }
    #box {
        flex: 1; 
        display: flex;
        justify-content: center;
    }
</style>
