<script>
    import { page } from "$app/state";
    let show = $state(false);
</script>

<nav>
    <ul>
        <li><a href="/"> <img src="/icons/homeagain.png" alt="home" />Home</a> </li>
        <li><a href="/routines" class:active={page.url.pathname === "/routines"}><img src="/icons/wirte.png" alt="notes" />Routines</a></li>
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
                height: 5rem;
                width: 19rem;
                border-radius: 1rem;
                margin-left: 1.5rem;
                margin-right: 1.5rem;
                margin-top: 2rem;

                &:active{
                    border-bottom: none;
                    border-top: 0.4rem solid var(--primary); 
                }
                a {
                    display: flex;
                    gap: 1rem;
                    align-items: center;
                    padding: 1rem;
                    text-decoration: none;
                    font-weight: bold   ;
                    color: var(--fourth);
                    height: 5rem;
                    background-color: var(--primary);

                    &:hover {
                        background-color: var(--third);
                        border-radius: 1.5rem;
                        height: 5.4rem;
                        border-bottom: 0.4rem solid var(--secondary);
                    }

                    &:active {
                        border-bottom: none;
                        height: 5rem;
                    }
                    
                    &.active {
                        color: var(--primary);
                        background-color: var(--fourth);
                        border-radius: 1rem;
                        &:hover{
                            border-bottom: 0.4rem solid var(--third);
                        }
                        &:active{
                            border-bottom: none;
                        }
                    }
                    img {
                        width: 2.5rem;
                    }
                }
            }
        }
    }
</style>
