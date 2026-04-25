<script>
    import { goto } from "$app/navigation";

    let firstname = $state("");
    let surname = $state("");
    let username = $state("");
    let email = $state("");
    let password = $state("");

    let success = $state(false);
    let loading = $state(false);
    let message = $state("");

    async function handleRegister() {
        if (loading) return; // Avbryt om vi redan skickar

        loading = true;
        message = "";

        try {
            // Skapa ett FormData-objekt
            const formData = new FormData();
            formData.append("firstname", firstname);
            formData.append("surname", surname);
            formData.append("username", username);
            formData.append("email", email);
            formData.append("password", password);

            const response = await fetch("/api/addUser.php", {
                method: "POST",
                body: formData,
            });

            if (!response.ok) throw new Error("Serverfel");

            const result = await response.json();
            message = result.message;
            success = result.success;

            if (success) {
                firstname = "";
                surname = "";
                username = "";
                email = "";
                password = "";
                goto("/login");
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
        <h1>Sign up</h1>

        <form action="" onsubmit={handleRegister}>
            <div>
                <label for="firstname">Firstname:</label> <br />
                <input type="text" id="firstname" bind:value={firstname} />
            </div>
            <div>
                <label for="surname">Surname:</label> <br />
                <input type="text" id="surname" bind:value={surname} />
            </div>
            <div>
                <label for="username">Username:</label> <br />
                <input type="text" id="username" bind:value={username} autocomplete=off/>
            </div>
            <div>
                <label for="email">Email:</label> <br />
                <input type="email" id="email" bind:value={email} autocomplete=off/>
            </div>
            <div>
                <label for="pass">Password:</label> <br />
                <input  
                    type="password"
                    id="pass"
                    bind:value={password}
                    minlength="6"
                />
            </div>

            {#if message}
                <p
                    class="status-msg"
                    style="color: {success ? 'green' : 'red'}"
                >
                    {message}
                </p>
            {/if}

            <input class="submit" type="submit" disabled={loading} />
        </form>

        <p>
            Already have an account? <a href="/login">Log in</a>
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
        justify-content: space-around;
    }  
</style>
