<script>
    import Nav from "./Nav.svelte";
    import Tugn from "$lib/assets/tugnIcon.png"
</script>

<header>
    <h1>TUGN <img src="{Tugn}" alt="Hammare" /> </h1>
    <Nav />
</header>

<style lang="scss">
    header {
        position: fixed;
        display: inline-block;
        min-height: 100vh;
        background-color: var(--primary);
        color: var(--fourth);

        h1 {
            width: 18rem;
            display: flex;
            font-size: 3rem;
            margin: 2rem;
            height: 6rem;
            align-items: center;
            letter-spacing: 0.5rem;

            img {
                position: relative;
                left: -1rem;
                width: 9rem;
            }
        }
    }
</style>
