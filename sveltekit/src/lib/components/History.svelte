<script>
    import { getTimeAgo } from "$lib/utils/format";

    let { workout, profileUser } = $props();

    let workoutDate = $derived(() => {
        let date = workout.date;
    });

    let displayDuration = $derived(() => {
        let totalSeconds = workout.duration;
        if (totalSeconds < 60) return `${totalSeconds}s`;

        const hours = Math.floor(totalSeconds / 3600);
        const minutes = Math.floor((totalSeconds % 3600) / 60);
        const seconds = totalSeconds % 60;

        if (hours > 0) return `${hours}h ${minutes}m`;
        return `${minutes}m ${seconds}s`;
    });
</script>

<article class="workout-card">
    <header class="card-header">
        <div class="user-info">
            <span class="username">@{profileUser.username}</span>
            <span class="date">{getTimeAgo(workout.date)}</span>
        </div>
        <h1 class="workout-title">{workout.name}</h1>
    </header>

    <div class="stats-grid">
        <div class="stat-item">
            <span class="label">Time</span>
            <span class="value">{displayDuration()}</span>
        </div>
        <div class="stat-item">
            <span class="label">Volume</span>
            <span class="value">{workout.volume} kg</span>
        </div>
        <div class="stat-item">
            <span class="label">Sets</span>
            <span class="value">{workout.sets}</span>
        </div>
    </div>

    <div class="exercises-list">
        {#each workout.exercises as exercise, index}
            <div class="exercise-row">
                <div class="index-left">
                    <span class="exercise-index">{index + 1} </span>
                    <span class="exercise-name">{exercise.name}</span>
                </div>
                <span class="sets-badge">
                    {exercise.sets.length}
                    {exercise.sets.length > 1 ? "sets" : "set"}
                </span>
            </div>
        {/each}
    </div>
</article>

<style lang="scss">
    .workout-card {
        background-color: rgb(250, 250, 250);
        border: 1px solid rgb(235, 235, 235);
        border-radius: 1rem;
        padding: 1.5rem;
        margin: 1.5rem;
        margin-top: 0;
        font-family: "DM Sans", sans-serif;

        .card-header {

            .user-info {
                display: flex;
                flex-direction: column;
                margin-bottom: 0.5rem;

                .username {
                    font-weight: 700;
                    font-size: 1.6rem;
                    color: #333;
                }

                .date {
                    font-size: 1.3rem;
                    color: #888;
                }
            }

            .workout-title {
                font-size: 1.6rem;
                font-weight: 800;
                margin: 0;
                color: #111;
                text-transform: uppercase;
                letter-spacing: -0.02em;
            }
        }

        .stats-grid {
            display: flex;
            gap: 2.5rem;
            padding: 1rem 0;
            border-top: 1px solid rgb(219, 225, 236);
            border-bottom: 1px solid rgb(219, 225, 236);
            margin-bottom: 1rem;

            .stat-item {
                display: flex;
                flex-direction: column;

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

        .exercises-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;

            .exercise-row {
                display: flex;
                justify-content: space-between;
                align-items: center;

                span {
                    font-size: 1.6rem;
                }

                .index-left {
                    display: flex;
                    gap: 2rem;
                }

                .exercise-index {
                    width: 1rem;
                }

                .exercise-name {
                    font-weight: 600;
                    color: #333;
                }

                .sets-badge {
                    background-color: #f0f0f0;
                    padding: 0.2rem 0.6rem;
                    border-radius: 0.5rem;
                    color: #666;
                    font-weight: 500;
                }
            }
        }
    }
</style>
