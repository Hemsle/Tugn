<script>
    import { goto, invalidateAll, replaceState, afterNavigate } from "$app/navigation";
    import { page } from "$app/state";
    import { onMount, tick } from "svelte";

    let nameOrMail = $state("");
    let password = $state("");

    let success = $state(false);
    let loading = $state(false);

    const loggedOutParam = page.url.searchParams.get('loggedout');
    let message = $state(page.url.searchParams.get('loggedout') === 'true' ? "Logged out!" : "");

    onMount(async () => {
        // Vänta tills SvelteKit har renderat klart första gången
        await tick();
        
        if (loggedOutParam) {
            const url = new URL(window.location.href);
            url.searchParams.delete('loggedout');
            
            // Vi kör replaceState inuti en try/catch för att vara helt säkra
            try {
                replaceState(url.pathname + url.search, {});
            } catch (e) {
                // Fallback om routern fortfarande inte är redo
                console.warn("Router not ready for replaceState, skipping URL cleanup.");
            }
        }
    });

    async function handleLogin() {
        event.preventDefault();
        if (loading) return; // Avbryt om vi redan skickar

        loading = true;
        message = "";

        try {
            // Skapa ett FormData-objekt
            const formData = new FormData();
            formData.append("nameOrMail", nameOrMail);
            formData.append("password", password);

            const response = await fetch("/api/login.php", {
                method: "POST",
                body: formData,
                credentials: 'include'
            });

            if (!response.ok) throw new Error("Serverfel");

            const result = await response.json();
            message = result.message;
            success = result.success;

            if (success) {
                await invalidateAll();
                goto("/");
            }
        } catch (err) {
            message = "Kunde inte nå servern. Kontrollera din anslutning.";
            success = false;
        } finally {
            loading = false;
        }
    }
    
</script>

<section class="content">
    <section id="login-info">
        <h1>Log in</h1>
        <form action="" onsubmit={handleLogin}>
        <div>
            <label for="name-mail">Username or email:</label> <br />
            <input
                type="text"
                id="name-mail"
                name="nameOrMail"
                bind:value={nameOrMail}
            />
        </div>
        <div>
            <label for="pass">Password:</label> <br />
            <input
                type="password"
                id="pass"
                bind:value={password}
                autocomplete="current-password"
            />
        </div>

        {#if message}
            <p class="status-msg" style="color: {success ? 'green' : 'red'}">
                {message}
            </p>
        {/if}

        <input class="submit" type="submit" value="Log in" disabled={loading}>

    </form>

        <p>
            Don't have an account? <a href="/login/register">Sign up</a>
        </p>
    </section>
</section>

<style lang="scss">
    .status-msg {
        font-weight: bold;
        margin-bottom: 1rem;
    }
    .content {
        display: flex;
        background-color: var(--secondary);
        min-width: 100%;
        align-items: center;
        padding: 2rem;
        justify-content: space-around;
    }
</style>
