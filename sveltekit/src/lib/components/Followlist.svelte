<script>
    let { profileUser } = $props();

    let showFollowers = $state(true);
</script>

<section class="follow-list">
    <div class="follow-grouping">
        <button
            class="followers-btn"
            class:active={showFollowers}
            onclick={() => (showFollowers = true)}>Followers</button
        >
        <button
            class="following-btn"
            class:active={!showFollowers}
            onclick={() => (showFollowers = false)}>Following</button
        >
    </div>

    <ul class="follower-list">
        {#if showFollowers}
            {#each profileUser.followers as user}
                <li>
                    <a href="/profile/{user.username}">
                        @{user.username}
                        <span>({user.display_name})</span>
                    </a>
                </li>
            {/each}
        {:else}
             {#each profileUser.following as user}
                <li>
                    <a href="/profile/{user.username}">
                        @{user.username}
                        <span>({user.display_name})</span>
                    </a>
                </li>
            {/each}   
        {/if}
    </ul>
</section>

<style lang="scss">
    .follow-list {
        display: flex;
        flex-direction: column;
        background-color: white;
        border: 0.1rem solid var(--border);
        border-radius: 1.5rem;
        border-bottom: 0.3rem solid var(--bottom);
        width: 100%;
        height: 40vh;
        overflow: hidden;

        .follow-grouping {
            display: flex;
            justify-content: space-evenly;
            border-bottom: var(--third) solid 0.3rem;

            button {
                border-radius: 0;
                width: 100%;
                border: var(--gray) solid 1rem;

                &:hover {
                    border-color: var(--third-light);
                    background-color: var(--third-light);
                }

                &.active {
                    border-color: var(--third);
                    background-color: var(--third);
                    color: white;
                }
            }

            .followers-btn {
                border-top-left-radius: 1rem;
            }

            .following-btn {
                border-top-right-radius: 1rem;
            }
        }

        .follower-list {
            overflow-y: auto;
            flex-grow: 1;

            li {
                max-width: 100%;
                padding: 1rem;
                list-style: none;
                padding: 1rem;

                &:hover {
                    background-color: var(--gray);
                }

                a {
                    display: block;
                    text-decoration: none;
                    color: black;
                    font-size: 1.6rem;
                    white-space: nowrap;    
                    overflow: hidden;         
                    text-overflow: ellipsis;

                    span {
                        color: #666;
                        font-size: 1.3rem;
                        margin-left: 0.5rem;
                    }

                    &:hover {
                        text-decoration: underline;
                    }
                }
            }
        }
    }
</style>
