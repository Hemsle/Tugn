<script>
    let { data } = $props();

    let user = $derived(data.user);

    let displayName = $state("");
    let username = $state("");
    let email = $state("");
    let bio = $state("");
    let newPassword  = $state("");
    let repeatedPass = $state("");
    let currentPassword = $state("");

    let success = $state(false);
    let loading = $state(false);
    let message = $state("");

    async function handleUpdate() {
        if (loading) return; 

        loading = true;
        message = "";

        try {
            const formData = new FormData();
            formData.append("displayName", displayName);
            formData.append("username", username);
            formData.append("email", email);
            formData.append("bio", bio);
            formData.append("password", newPassword);
            formData.append("newPassword", repeatedPass);
            formData.append("confirmPassword", currentPassword);

            const response = await fetch("/api/updateUser.php", {
                method: "POST",
                body: formData,
            });

            const result = await response.json();
            message = result.message;
            success = result.success;

            if (success) {
                newPassword = "";
                repeatedPass = "";
                currentPassword = "";
                
                window.location.reload();
            }

        } catch (err) {
            message = "Can't connect to server";
            success = false;
        } finally {
            loading = false;
        }
    }

</script>


<section class="content">
    <section class="edit-profile">
        <h1>Edit Profile</h1>

        <form action="" onsubmit={handleUpdate}>
            <div>
                <label for="firstname">Full name:</label> <br />
                <input type="text" placeholder={user.display_name} id="firstname" bind:value={displayName} />
            </div>
            <div>
                <label for="username">Username:</label> <br />
                <input type="text" placeholder={user.username} id="username" bind:value={username} autocomplete=off/>
            </div>
            <div>
                <label for="bio">Biography:</label> <br />
                <input type="text" placeholder={user.bio} id="bio" bind:value={bio} autocomplete=off>
            </div>
            <div>
                <label for="email">Email:</label> <br />
                <input type="email" placeholder={user.email} id="email" bind:value={email} autocomplete=off/>
            </div>
            <div>
                <label for="newpass">New password:</label> <br />
                <input type="password" id="newpass" bind:value={newPassword} minlength="6" autocomplete=off/>
            </div>
            <div>
                <label for="passrepeat">Repeat new password:</label> <br />
                <input type="password" id="passrepeat" bind:value={repeatedPass} autocomplete=off/>
            </div>
            <div>
                <label for="pass">Confirm with password:</label> <br />
                <input  
                    type="password"
                    id="pass"
                    bind:value={currentPassword}
                    minlength="6"
                />
            </div>

            {#if message}
                <p class="status-msg" style="color: {success ? 'green' : 'red'}">
                    {message}
                </p>
            {/if}

            <input class="submit" type="submit" value="Submit" disabled={loading} />
        </form>
    </section>
</section>


<style lang="scss">
    .content {
        display: flex;

    }
    .edit-profile {
    display: flex;
    background-color: white;
    border: 0.1rem solid rgb(231, 231, 231);
    border-radius: 1.5rem;
    border-bottom: 0.3rem solid rgb(214, 214, 214);
    width: 100%;
    max-width: 22rem;
    padding: 2rem;
    justify-content: center;
    flex-direction: column;
    align-items: flex-start;

    input {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
        width: 100%;
        margin-bottom: 10px;
        font-size: 1.3;
    }

    #bio {
        height: 10rem;
    }

    .submit {
        padding: 0.5rem 1rem;
        background-color: var(--primary, #333);
        color: white;
        border: none;
        border-radius: 0.5rem;

        &:hover {
            background-color: var(--secondary);
        }

        &:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
    }

    h1 {
        font-size: 2.3rem;
    }

    label {
        font-size: 1.3rem;
    }
}
</style>