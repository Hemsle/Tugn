<script>
    import FollowStats from "$lib/components/FollowStats.svelte";
    import History from "$lib/components/History.svelte";

    let { data, isOwnProfile = false } = $props();

    let isFollowing = $state(data.isFollowing);
    let allWorkouts = $state(data.initialWorkouts || []);

    let profileUser = $derived(isOwnProfile ? data.user : data.visitedUser);

    async function loadMore() {
        const offset = allWorkouts.length;
        const url = isOwnProfile
            ? `/api/userProfileStats.php?offset=${offset}`
            : `/api/userProfileStats.php?username=${profileUser.username}&offset=${offset}`;

        const response = await fetch(url);
        const result = await response.json();

        // Om det är någon annans profil ligger workouts i result.workouts
        // Om det är min egen är resultatet direkt en array
        const newWorkouts = result.workouts;

        if (Array.isArray(newWorkouts)) {
            allWorkouts = [...allWorkouts, ...newWorkouts];
        }
    }

    async function toggleFollow() {
        const previousState = isFollowing;
        isFollowing = !isFollowing;

        if (isFollowing) stats.followers++;
        else stats.followers--;

        const formData = new FormData();
        formData.append("following_id", profileUser.uid);

        try {
            const response = await fetch("/api/toggleFollow.php", {
                method: "POST",
                body: formData,
            });
            const result = await response.json();

            // Om servern säger något annat än vad vi trodde, korrigera (t.ex. vid fel)
            if (result.error) {
                isFollowing = previousState;
                if (isFollowing) stats.followers++;
                else stats.followers--;
            }
        } catch (e) {
            // Vid nätverksfel, återställ
            isFollowing = previousState;
            if (isFollowing) stats.followers++;
            else stats.followers--;
        }
    }
</script>

<section class="content">
    <section class="profile-info">
        <div class="profile-user">
            <div class="name-follower">
                <h1>{profileUser?.display_name}</h1>

                <FollowStats {profileUser} {isOwnProfile}/>
            </div>

            {#if isOwnProfile}
                <button>Edit profile </button>
            {/if}
        </div>
        <h2>@{profileUser?.username}</h2>

        <p>{profileUser?.bio || "No bio yet"}</p>

        {#if !isOwnProfile}
            <button
                onclick={toggleFollow}
                class="follow-btn"
                class:is-following={isFollowing}
            >
                <span class="text-normal">
                    {isFollowing ? "Following" : "Follow"}
                </span>
                {#if isFollowing}
                    <span class="text-hover">Unfollow</span>
                {/if}
            </button>
        {/if}
    </section>

    <section class="feed">
        <h1>Workouts</h1>
        {#each allWorkouts as workout}
            <History {workout} {profileUser} />
        {/each}

        {#if allWorkouts.length >= 10 && allWorkouts.length % 10 === 0}
            <button onclick={loadMore}>Load More</button>
        {:else if allWorkouts.length === 0}
            <p style="margin: 1.8rem; margin-top: 0;">No workouts yet</p>
        {/if}
    </section>
</section>

<style lang="scss">
    .content {
        flex-direction: column;
        justify-content: flex-start;

        .profile-info {
            background-color: white;
            border: 0.1rem solid rgb(231, 231, 231);
            border-radius: 1.5rem;
            border-bottom: 0.3rem solid rgb(214, 214, 214);
            width: 100%;
            padding: 2rem;

            .profile-user {
                display: flex;
                justify-content: space-between;

                .name-follower {
                    display: flex;
                    gap: 2rem;
                }
            }

            .account {
                padding: 0.5rem 1rem;
                background-color: var(--third);
                color: white;
                border: none;
                border-radius: 0.5rem;

                &:hover {
                    background-color: var(--third-light);
                }
                a {
                    color: black;
                    text-decoration: none;
                }
            }

            .follow-btn {
                padding: 0.5rem;
                border-radius: 2rem;
                min-width: 10rem;
                border: 1px solid var(--third);
                background: var(--third);
                color: white;

                .text-hover {
                    display: none; // Dölj Unfollow som standard
                }

                &:hover {
                    opacity: 0.9;
                }

                &.is-following {
                    background: white;
                    color: black;
                    border: 1px solid #ccc;

                    &:hover {
                        border-color: #ff4444;
                        color: #ff4444;
                        background-color: #fff5f5;

                        .text-normal {
                            display: none; 
                        }
                        .text-hover {
                            display: inline; 
                        }
                    }
                }
            }
        }

        .feed {
            display: flex;
            background-color: white;
            border: 0.1rem solid rgb(231, 231, 231);
            border-radius: 1.5rem;
            border-bottom: 0.3rem solid rgb(214, 214, 214);
            width: 65%;
            flex-direction: column;
            h1 {
                margin: 1.8rem;
                margin-bottom: 0;
            }

            button {
                margin: 1.5rem;
                margin-top: 0;
                padding: 0.5rem;
                background-color: var(--third);
                color: white;
                border: none;
                border-radius: 1rem;

                &:hover {
                    background-color: var(--third-light);
                }
            }
        }
    }
</style>
