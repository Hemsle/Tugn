<!--routes/+page.svelte-->
<script>
    import { goto } from "$app/navigation";

    import { searched, filteredExercises, selectedExercise, addExercises } from "$lib/stores/exerciseStore";
    filteredExercises.set([]);
    selectedExercise.set(null);
    addExercises.set(false);
    searched.set(false); 

    function startEmptyWorkoput() {
        goto("/routines/emptyWorkout");
    }
</script>

<section>
    <h1>Quick Start</h1>

    <button id="emptyWorkout" onclick={startEmptyWorkoput}>
        <img src="/icons/plus.png" alt="plus">
        <p>Start Empty Workout</p>
    </button>
</section>

<style lang="scss">
    section {
        position: absolute;
        left: 40%;
        margin-top: 3rem;

        h1 {
            font-size: 3rem;
        }

        #emptyWorkout {
            font-family: "DM sans", sans-serif;
            display: flex;
            width: 30rem;
            height: 4rem;
            align-items: center;
            img {
                height: 100%;
                margin-right: 0.5rem;
            }

            p {
                font-size: 2rem;
                font-weight: 500;
            }
        }
    }
</style>
