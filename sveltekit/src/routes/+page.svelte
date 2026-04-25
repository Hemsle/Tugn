<script>
    import { goto } from "$app/navigation";
    import UserHome from "$lib/components/UserHome.svelte";

    let { data } = $props();

    console.log("Profile data: ", data);

    let searchQuery = $state("");
    let searchResults = $state([]);
    let isSearching = $state(false);

    async function handleSearch(e) {
        searchQuery = e.target.value;

        if (searchQuery.length < 2) {
            searchResults = [];
            isSearching = false;
            return;
        }

        isSearching = true;

        try {
            const response = await fetch(
                `api/searchUsers.php?q=${encodeURIComponent(searchQuery)}`,
            );
            const data = await response.json();

            if (Array.isArray(data)) {
                searchResults = data;
            }
        } catch (err) {
            console.error("Sökfel: ", err);
        }
    }

    function onBlur() {
        isSearching = false;
    }
</script>

<section class="content">
    {#if data.user}
        <section class="feed">
            <div class="feed-header">
                <h1>Workouts</h1>
                <div class="search-container">
                    <div class="search-field">
                        <img
                            src="/icons/searchglass.png"
                            alt="search icon"
                            class="search-icon"
                        />
                        <input
                            type="text"
                            placeholder="Search users..."
                            bind:value={searchQuery}
                            oninput={handleSearch}
                        />
                    </div>
                    {#if searchResults.length > 0 && isSearching}
                        <ul class="search-results">
                            {#each searchResults as user}
                                <li>
                                    <a href="/profile/{user.username}">
                                        @{user.username}
                                        <span>({user.display_name})</span>
                                    </a>
                                </li>
                            {/each}
                        </ul>
                    {/if}
                </div>
            </div>
        </section>
        <section id="user">
            <UserHome {data} />
        </section>
    {:else}
        <section id="welcome">
            <h1>Welcome to Tugn</h1>
            <p>Please log in to see your individual dashboard</p>
            <button onclick={() => goto("/login")}> Log in </button>
        </section>
    {/if}
</section>

<style lang="scss">
    .content {
        section {
            background-color: white;
            border: 0.1rem solid rgb(231, 231, 231);
            border-radius: 1.5rem;
            border-bottom: 0.3rem solid rgb(214, 214, 214);
            padding: 2rem;
        }

        #user {
            display: flex;
            max-width: 25rem;
            max-height: 30rem;
            width: 100%;
            height: 100%;
            flex-direction: column;
            align-items: center;
        }

        .feed {
            width: 100%;

            .feed-header {
                display: flex;
                justify-content: space-between;
                margin-bottom: 1rem;
                gap: 1rem;

                h1 {
                    font-size: 2.3rem;
                }
                .search-container {
                    .search-field {
                        display: flex;
                        align-items: center;
                        background-color: #efefef;
                        padding: 0.6rem 1.2rem;
                        border-radius: 2rem;
                        width: 100%;
                        max-width: 25rem;
                        border: 1px solid transparent;
                        transition: all 0.2s ease;

                        &:focus-within {
                            background-color: white;
                            border-color: var(--third);
                            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);
                        }

                        .search-icon {
                            width: 2rem;
                            opacity: 0.5;
                            margin-right: 0.8rem;
                        }

                        input {
                            border: none;
                            background: transparent;
                            outline: none;
                            width: 100%;
                            font-family: inherit;
                            font-size: 1.3rem;
                            color: #333;

                            &::placeholder {
                                color: #aaa;
                            }
                        }
                    }

                    .search-results {
                        background-color: white;
                        border-color: var(--third);
                        border-radius: 2rem;
                        box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);
                        width: 100%;
                        max-width: 24.6rem;
                        padding: 0.6rem 1.2rem;
                        li {
                            list-style: none;
                            padding: 0.5rem 0;

                            a {
                                text-decoration: none;
                                color: #333;
                                font-size: 1.1rem;

                                span {
                                    color: #666;
                                    font-size: 0.9rem;
                                    margin-left: 0.5rem;
                                }

                                &:hover {
                                    text-decoration: underline;
                                }
                            }
                        }
                    }
                }
            }
        }
        #welcome {
            max-width: 100rem;
            width: 100%;
            height: 15%;
        }
    }
</style>
