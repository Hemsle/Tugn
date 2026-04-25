<script>
    import { goto } from "$app/navigation";
    import { workout } from "$lib/stores/workoutStore.js";
    import { onMount } from "svelte";
    import { startGlobalTimer, seconds } from "$lib/stores/timerStore";
    import { discardWorkout } from "$lib/stores/workoutStore.js";
    import Library from "$lib/components/Library.svelte";
    import ExerciseSets from "$lib/components/ExerciseSets.svelte";
    import Searched from "$lib/components/Searched.svelte";
    import Exercise from "$lib/components/Exercise.svelte";
    import Timer from "$lib/components/Timer.svelte";
    import { formatOption } from "$lib/utils/format.js";
    import {
        addExercises,
        searched,
        selectedExercise,
        filteredExercises,
        showLibrary,
        selectedExercises,
    } from "$lib/stores/exerciseStore.js";
    import WorkoutTitle from "./WorkoutTitle.svelte";

    let { data } = $props();

    onMount(() => {
        startGlobalTimer();
    });

    async function finishWorkout() {
        // Fråga användaren först (valfritt men bra)
        if (!confirm("Vill du avsluta och spara träningspasset?")) return;

        //Uppdatera storen en sista gång med tiden från timern
        workout.update((w) => {
            w.duration = $seconds;
            return w;
        });

        try {
            //Skicka datan till PHP
            // Vi använder $workout direkt eftersom den nu innehåller allt (namn, datum, exercises, volume, duration)
            const response = await fetch("/api/saveWorkout.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify($workout),
                credentials: "include", // Viktigt för att PHP-sessionen user_id ska följa med
            });

            const result = await response.json();

            if (result.status === "success") {
                console.log(result.message);

                //Rensa träningen från storen och localStorage eftersom den nu är sparad
                discardWorkout();

                // Skicka användaren till historiken eller startsidan
                goto("/routines");
            } else {
                alert("Fel: " + result.message);
            }
        } catch (err) {
            console.error("Kunde inte spara passet:", err);
            alert("Kunde inte nå servern. Kontrollera din anslutning.");
        }
    }

    function library() {
        if (!$showLibrary) {
            addExercises.set(true);
            showLibrary.set(true);
            searched.set(false);
        } else {
            const newExercises = $selectedExercises.map((exercise) => ({
                id: exercise.id,
                name: exercise.name,
                type: exercise.type,
                muscle: exercise.muscle,
                equipments: exercise.equipments,
                sets: [{ weight: "", reps: "", completed: false }], // Första setet
            }));

            workout.update((current) => {
                if (!current) return current;

                const existingExercises = Array.isArray(current.exercises)
                    ? current.exercises
                    : [];

                return {
                    ...current,
                    exercises: [...existingExercises, ...newExercises],
                };
            });

            selectedExercises.set([]);
            addExercises.set(false);
            showLibrary.set(false);
            searched.set(false);
        }
    }

    function close() {
        goto("/routines");
    }
</script>

<section class="workout">
    <section id="top">
        <button class="nav-btn" onclick={close}>Close</button>

        <WorkoutTitle />

        <button class="nav-btn" onclick={finishWorkout}>Finish</button>
    </section>
    <section class="workout-overview">
        <span>Date: {$workout.date}</span>
        <span class="timer"><Timer /></span>
        <span class="volume">Volume: {$workout.volume} kg Sets: {$workout.sets}</span>
    </section>

    <section id="workout-info">
        <section id="find-exercises">
            {#if $searched && $showLibrary}
                <Searched />
            {:else if $selectedExercise}
                <Exercise {$selectedExercise} />
            {:else if $workout}
                <!--length-->
                <div class="exercise-list">
                    <ExerciseSets />
                </div>
            {:else}
                <div class="exercise-list">
                    <p style="font-size: large;">No exercises</p>
                </div>
            {/if}
        </section>

        <button onclick={library} id="add-exercise">
            <img src="/icons/plus.png" alt="plus" />
            <p>Add Exercise</p>
        </button>
    </section>
</section>

<style lang="scss">
    .workout {
        background-color: white;
        max-width: 63rem;
        width: 100%;
        height: 99.8%;
        border: 0.1rem solid rgb(231, 231, 231);
        border-radius: 1.5rem;
        border-bottom: 0.3rem solid rgb(214, 214, 214);
        justify-items: center;
        background-color: white;

        .workout-overview {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            width: 92%;
            padding: 1rem 0;
            font-weight: 600;
            font-size: 1.3rem;

            span:first-child {
                justify-self: start;
                white-space: nowrap;
            }

            .timer {
                justify-self: center;
                text-align: center;
            }

            .volume {
                justify-self: end;
                text-align: right;
                display: block;
                width: auto;
            }
        }

        #top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 97%;
            height: 5%;
            padding-top: 1rem;
            padding-bottom: 1rem;
            

            .title-container {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                position: relative;

                input {
                    font-size: 1.5rem;
                    font-weight: bold;
                    font-family: inherit;
                    border: none;
                    border-bottom: 2px solid var(--third);
                    text-align: center;
                    outline: none;
                    width: auto;
                    max-width: 20rem;
                }

                button {
                    position: relative;
                    display: flex;
                    align-items: center;
                    height: 100%;
                    img {
                        width: 2rem;
                        opacity: 0.6;
                    }
                }
            }
        }

        #workout-info {
            width: 94%;
            max-height: 81rem;
            height: 100%;

            #find-exercises {
                max-height: 75rem;
                height: 100%;
                #chosen-exercise {
                    margin: 0;
                    padding: 2rem;
                    p {
                        margin: 0rem;
                    }
                }
            }
            #add-exercise {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                gap: 0.5rem;
                p {
                    font-size: medium;
                    font-weight: 600;
                    font-family: "DM sans", sans-serif;
                }
                img {
                    width: 3rem;
                }
            }
        }
    }
</style>
