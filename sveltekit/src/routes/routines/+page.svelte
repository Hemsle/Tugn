<!--routes/+page.svelte-->
<script>
    import { goto } from "$app/navigation";

    import {
        searched,
        filteredExercises,
        selectedExercise,
        addExercises,
        showLibrary,
    } from "$lib/stores/exerciseStore";

    import Routines from "$lib/components/Routines.svelte";
    import { displayTime } from "$lib/stores/timerStore";
    import { workout, discardWorkout } from "$lib/stores/workoutStore";

    filteredExercises.set([]);
    selectedExercise.set(null);
    addExercises.set(false);
    searched.set(false);
    showLibrary.set(false);

    let { data } = $props();

    function startEmptyWorkout() {
        goto("/routines/emptyWorkout");
    }

    function confirmDiscard() {
        discardWorkout();
        goto("/routines");

        console.log($workout);
    }
</script>

<section class="content">
    <h1>Quick Start</h1>
    {#if data.user === null}
        <p style="font-size: large;">Log in to access workouts</p>
    {:else if $workout === null || $workout.length === 0}
        <button id="empty-workout" onclick={startEmptyWorkout}>
            <img src="/icons/plus.png" alt="plus" />
            <p>Start Empty Workout</p>
        </button>
    {:else}
        <div class="current-workout">
        <button id="resume-workout" onclick={() => goto("/routines/emptyWorkout")}>
                <h4>{$workout.name} ({$workout.exercises.length} exercises) {$displayTime}</h4>

                
        </button>

        <button id="discard-workout" onclick={confirmDiscard}><h4>Discard</h4></button>
        </div>
    {/if}


    {#if data.user}
        <Routines />
    {/if}
</section>

<style lang="scss">
    .content {
        flex-direction: column;
        justify-content: flex-start;

        h1 {
            font-size: 3rem;
        }

        #empty-workout {
            font-family: "DM sans", sans-serif;
            display: flex;
            width: 30rem;
            height: 4rem;
            align-items: center;
            border-radius: 1rem;
            padding: 1rem;
            img {
                height: 100%;
                margin-right: 0.5rem;
            }
            p {
                font-size: 2rem;
                font-weight: 500;
            }
        }

        .current-workout {

            #resume-workout {
                padding: 1rem;
                border-radius: 2rem;
            }

            #discard-workout {
                background-color: #dd0000;
                padding: 0.5rem;
                border-radius: 3rem;
                &:hover {
                    background-color: #b90000;
                }   
            }
        }
    }
</style>
