<script>
    import Nav from "./Nav.svelte";
</script>

<header>
    <img src="icons/tugnIcon.png" alt="Hammare" />
    <h1>TUGN</h1>
    <Nav />
</header>

<style lang="scss">
    header {
        display: inline-block;
        width: 22rem;
        position: fixed;
        height: 100%;
        background-color: var(--primary);
        color: var(--fourth);
        img {
            width: 12rem;
            position: absolute;
            top: -1rem;
            left: 10rem;
            z-index: -1;
        }

        h1 {
            position: relative;
            z-index: 0;
            font-size: 3rem;
            font-weight: bold;
            margin: 2rem;
        }
    }
</style>
