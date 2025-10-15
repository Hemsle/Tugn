<script>
    import Nav from "./Nav.svelte";
</script>

<header>
    <h1>TUGN</h1>
    <Nav />
</header>

<style lang="scss">
    header {
        width: 22rem;
        position: fixed; 
        display: inline-block;
        height: 100%; 
        background-color: var(--primary);
        color: var(--fourth);
        h1 {
            font-size: 3rem;
            font-weight:bold;
            margin: 2rem; 
        }
    }
</style>
