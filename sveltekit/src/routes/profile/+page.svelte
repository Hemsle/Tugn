<script>
    import { goto } from "$app/navigation";
    import ProfilePage from "$lib/components/ProfilePage.svelte";
    let { data } = $props();
</script>

{#if data.user}
    <ProfilePage {data} isOwnProfile={true} />
{:else}
    <section class="content">
        <section class="no-profile">
            <h1>You are not logged in</h1>
            <button class="login" onclick={()=>goto("/login")}>
                Log in
            </button>
        </section>
    </section>
{/if}

<style lang="scss">
    .content {
        justify-content: flex-start;

        .no-profile {
            background-color: white;
            border: 0.1rem solid rgb(231, 231, 231);
            border-radius: 1.5rem;
            border-bottom: 0.3rem solid rgb(214, 214, 214);
            max-width: 75rem;
            width: 100%;
            padding: 2rem;

            .login {
                background-color: var(--third);
                padding: 0.5rem 1rem;
                color: black;
                border: none;
                border-radius: 0.5rem;
                &:hover {
                    background-color: var(--third-light);
                }
            }
        }
    }
</style>
