<script>
    import { page } from "$app/state";
    let show = $state(false);
</script>

<nav>
    <ul>
        <li><a href="/"> <img src="/icons/homeagain.png" alt="home" />Home</a> </li>
        <li><a href="/"> <img src="/icons/wirte.png" alt="notes" />Routines</a></li>
        <li><a href="/exercises" class:active={page.url.pathname === "/exercises"}><img src="/icons/dumbbell.png" alt="dumbbell" />Exercises</a></li>
        <li><a href="/"> <img src="/icons/user.png" alt="user" />Profile</a></li>
        <li><a href="/"><img src="/icons/settings.png" alt="cogwheel" />Settings</a></li>
    </ul>
</nav>

<style lang="scss">
    nav {
        margin: 0rem;
        ul {
            list-style: none;
            li {
                font-size: 1.7rem;
                align-items: center;
                justify-content: center;
                margin: 1.5rem;
                border: 0.1rem solid var(--primary);
                border-radius: 1rem;

                &:hover {
                    background-color: var(--third);
                    border: 0.1rem solid var(--third);
                    border-bottom: 0.4rem solid var(--secondary);

                }
                a {
                    display: flex;
                    gap: 1rem;
                    align-items: center;
                    padding: 1rem;
                    padding-right: 5rem;
                    text-decoration: none;
                    font-weight: bold   ;
                    color: var(--fourth);
                    
                    &.active {
                        color: var(--primary);
                        background-color: var(--fourth);
                        border-radius: 1rem;
                    }
                    img {
                        width: 2.5rem;
                    }
                }
            }
        }
    }
</style>
