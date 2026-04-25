<script>
    import { goto } from "$app/navigation";
    import { discardWorkout } from "$lib/stores/workoutStore";
    import { refreshExercises } from "$lib/utils/fetchDB.js";

    let { data } = $props();

</script>

<section class="content">
    <section id="settings">
        <h1>Settings</h1> 

        {#if !data.user}
            <button 
                class="account" 
                id="login"
                onclick={() => goto("/login")}>
                Log in
            </button>
        {:else}
            <button  
                onclick={discardWorkout} 
                class="account" id="logout">
                <a href="api/logout.php">Log out</a>
            </button>
            <!--<button onclick={refreshExercises} class="account" id="refresh">Refresh exercises</button>-->
        {/if}
    </section>
</section>

<style lang="scss">
    .content {
        justify-content: flex-start;
    }

    #settings {
        background-color: white;
        border: 0.1rem solid rgb(231, 231, 231);
        border-radius: 1.5rem;
        border-bottom: 0.3rem solid rgb(214, 214, 214);
        max-width: 75rem;
        width: 100%;
        padding: 2rem;

        .account {
            padding: 0.5rem 1rem;
            background-color:#e40000;
            border: none;
            border-radius: 0.5rem;

            &:hover {
                background-color: #ff0000;
            }
            a {
                color: black;
                text-decoration: none;
            }
        }

        #logout {
            background-color: #e40000;
            &:hover {
                background-color: #ff0000;
            }
        }

        #login {
            background-color: var(--third);
            &:hover {
                background-color: var(--third-light);
            }
        }
    }
</style>
