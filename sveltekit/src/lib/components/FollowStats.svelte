<script>
    import { workout } from "$lib/stores/workoutStore";

    let { profileUser, isOwnProfile } = $props();

    let workoutCount = $derived(profileUser.workoutCount);
    let followers = $derived(profileUser.followers);
    let following = $derived(profileUser.following);

    let stats = $derived({
        workoutCount,
        followers,
        following,
    });
</script>

<div class="stats-grid">
{#key stats.following}
    <div class="stat-item">
        <span class="label">Workouts</span>
        <span class="value">{stats?.workoutCount}</span>
    </div>
    <div class="stat-item">
        <span class="label">Followers</span>
        <span class="value">{stats?.followers?.length}</span>
    </div>
    <div class="stat-item">
        <span class="label">Following</span>
        <span class="value">{stats?.following?.length}</span>
    </div>
{/key}
    
</div>

<style lang="scss">
    .stats-grid {
        display: flex;
        gap: 1rem;

        .stat-item {
            display: flex;
            flex-direction: column;
            align-items: center;

            .label {
                font-size: 1rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                color: #999;
                font-weight: 600;
            }

            .value {
                font-size: 1.5rem;
                font-weight: medium;
                color: #222;

                small {
                    font-size: 0.8rem;
                    color: #666;
                    font-weight: 500;
                }
            }
        }
    }
</style>
