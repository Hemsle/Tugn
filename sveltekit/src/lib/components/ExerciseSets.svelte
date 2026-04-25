<script>
    import { workout } from "$lib/stores/workoutStore";

    function updateWorkoutStats() {
        workout.update((w) => {
            if (!w || !w.exercises) return w;

            let newVolume = 0;
            let totalSets = 0;

            w.exercises.forEach((exercise) => {
                const completedSets = exercise.sets.filter((s) => s.completed);

                totalSets += completedSets.length;

                const exerciseVolume = completedSets.reduce(
                    (sAcc, s) =>
                        sAcc + (Number(s.weight) || 0) * (Number(s.reps) || 0),
                    0,
                );
                newVolume += exerciseVolume;
            });

            return { ...w, volume: newVolume, sets: totalSets };
        });
    }

    function addSet(exerciseIndex) {
        workout.update((current) => {
            const exercise = current.exercises[exerciseIndex];
            const sets = exercise.sets;
            const lastSet = sets[sets.length - 1];

            let newSet;
            if (exercise.type === "cardio") {
                newSet = {
                    duration: lastSet?.duration || "",
                    completed: false,
                };
            } else {
                newSet = {
                    weight: lastSet?.weight || "",
                    reps: lastSet?.reps || "",
                    completed: false,
                };
            }

            current.exercises[exerciseIndex].sets = [...sets, newSet];
            return current;
        });
    }

    function removeExercise(exerciseIndex) {
        workout.update((current) => {
            current.exercises.splice(exerciseIndex, 1);
            return current;
        });
        updateWorkoutStats();
    }

    function removeSet(exerciseIndex, setIndex) {
        workout.update((current) => {
            current.exercises[exerciseIndex].sets.splice(setIndex, 1);

            if (current.exercises[exerciseIndex].sets.length === 0) {
                current.exercises.splice(exerciseIndex, 1);
            }
            return current;
        });
        updateWorkoutStats();
    }

    function calculateVolume(exercise) {
        return exercise.sets
            .filter((set) => set.completed)
            .reduce(
                (total, set) => total + Number(set.weight) * Number(set.reps),
                0,
            );
    }
</script>

{#each $workout.exercises as exercise, i}
    <section class="exercise">
        <div class="exercise-header">
            <h2>{exercise.name}</h2>

            <div class="dropdown">
                <button class="options">
                    <img src="/icons/options.png" alt="dots" />
                </button>

                <div class="dropdown-content">
                    <button
                        class="remove-exercise"
                        onclick={() => removeExercise(i)}>Remove</button
                    >
                </div>
            </div>
        </div>

        <div class="labels">
            <span class="label-sets">SETS</span>
            {#if ["strength", "powerlifting", "strongman", "olympic_weightlifting"].includes(exercise.type)}
                <span class="label-weight">WEIGHT & REPS</span>
                <span class="label-volume">
                    VOLUME: {calculateVolume(exercise)} kg</span
                >
            {:else if exercise.type === "cardio"}
                <span class="label-weight">DURATION</span>
            {:else}
                <span class="label-weight">REPS</span>
            {/if}
        </div>

        <div class="sets-container">
            {#each exercise.sets as set, index}
                <div class="set-row" class:completed={set.completed}>
                    <div class="set-status">
                        <span class="set-number">
                            {index + 1}
                        </span>
                        <button
                            class="remove-set"
                            onclick={() => removeSet(i, index)}>Remove</button
                        >
                    </div>

                    <div class="set-inputs">
                        {#if ["strength", "powerlifting", "strongman", "olympic_weightlifting"].includes(exercise.type)}
                            <input
                                type="number"
                                placeholder="-"
                                bind:value={$workout.exercises[i].sets[index].weight}
                                onchange={() => updateWorkoutStats}
                            />
                            <span class="unit">kg</span>

                            <input
                                type="number"
                                placeholder="-"
                                bind:value={$workout.exercises[i].sets[index].reps}
                                onchange={updateWorkoutStats}
                            />
                            <span class="unit">reps</span>
                        {:else if exercise.type === "cardio"}
                            <div class="duration-container">
                                <input
                                    type="text"
                                    placeholder="00:00"
                                    bind:value={$workout.exercises[i].sets[index].duration}
                                    pattern="[0-9]{2}:[0-9]{2}"
                                    inputmode="numeric"
                                />
                                <span class="unit"></span>
                            </div>
                        {:else}
                            <input
                                type="number"
                                placeholder="-"
                                bind:value={$workout.exercises[i].sets[index].reps}
                                onchange={updateWorkoutStats}
                            />
                            <span class="unit">reps</span>
                        {/if}
                    </div>

                    <div class="set-action">
                        {#if (exercise.type === "cardio" && set.duration) || set.reps}
                            <input
                                type="checkbox"
                                bind:checked={$workout.exercises[i].sets[index].completed}
                                onchange={updateWorkoutStats}
                                class="check-input"
                            />
                        {/if}
                    </div>
                </div>
            {/each}

            <button class="add-set" onclick={() => addSet(i)}>
                + Add set
            </button>
        </div>
    </section>
{/each}

<style lang="scss">
    .exercise {
        font-family: "DM Sans", sans-serif;
        background: white;
        padding: 1rem;
        max-width: 100%;

        .exercise-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.1rem;
            justify-content: space-between;

            .exercise-icon {
                width: 45px;
                height: 45px;
                border: 1px solid #eee;
                border-radius: 50%;
                padding: 5px;
            }

            h2 {
                font-size: 1.7rem;
                font-weight: 600;
                color: #222;
                margin: 0;
            }

            .dropdown {
                position: relative;
                display: inline-block;

                .options {
                    background: none;
                    display: flex;

                    img {
                        width: 2rem;
                    }
                }

                .dropdown-content {
                    display: none;
                    position: absolute;
                    right: 1rem;
                    z-index: 1;
                    button {
                        background-color: red;
                    }
                }

                &:hover .dropdown-content {
                    display: block;
                }
            }
        }

        .labels {
            display: flex;
            font-size: 1.2rem;
            font-weight: 700;
            color: #999;
            margin-bottom: 0.75rem;
            padding-left: 0.5rem;
            width: 70%;
            justify-content: space-between;

            .label-sets {
                width: 6rem;
                padding-left: 0.6rem;
            }
            .label-weight {
                flex: 1;
                text-align: left;
                padding-left: 2rem;
            }
            .label-volume {
                text-align: left;
            }
        }

        .set-row {
            display: flex;
            align-items: center;
            padding: 0.75rem 0.5rem;
            border-radius: 1.2rem;
            transition: all 0.2s ease;
            margin-bottom: 0.4rem;

            &:nth-child(even) {
                background-color: #f4f6f8; // Den ljusgrå färgen från din bild
            }

            &.completed {
                background-color: #92ee99;
            }

            .set-status {
                width: 4rem;
                display: flex;
                justify-content: center;
                align-items: center;
                position: relative;

                .set-number {
                    display: block; // Visas som standard
                    font-weight: 800;
                    font-size: 1.5rem;
                    color: #333;
                }

                .remove-set {
                    display: none;
                    background: none;
                    border: none;
                    color: #ff4444;
                    cursor: pointer;
                    padding: 0;
                    padding-left: 1rem;
                    font-size: 1.5rem;
                }

                &:hover {
                    .set-number {
                        display: none;
                    }
                    .remove-set {
                        display: block;
                        margin-left: 1.5rem;
                    }
                }
            }

            .set-inputs {
                flex: 1;
                display: flex;
                align-items: center;
                gap: 4px;
                padding-left: 1.5rem;

                input {
                    width: 4.5rem;
                    border: none;
                    background: transparent;
                    font-size: 1.5rem;
                    font-weight: 500;
                    color: #333;
                    text-align: right;
                    padding: 0;

                    &:focus {
                        outline: none;
                    }
                    &::placeholder {
                        color: #ccc;
                    }
                }

                .unit {
                    font-size: 1.5rem;
                    color: #333;
                    font-weight: 500;
                }

                .duration-container {
                    display: flex;
                    align-items: center;

                    input {
                        width: 8rem; // Lite bredare för att få plats med "00:00"
                        text-align: center;
                        letter-spacing: 1px;
                    }
                }
            }

            .set-action {
                padding-right: 1rem;
                display: flex;

                .check-input {
                    width: 20px;
                    height: 20px;
                    cursor: pointer;
                    accent-color: #92ee99;
                }
            }
        }
        .add-set {
            width: 100%;
            border-radius: 1rem;
            padding: 0.5rem;
            font-weight: 600;
        }
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
