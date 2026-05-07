<!--routes/emptyWorkout/+page.svelte-->
<script>
    import { goto } from "$app/navigation";
    import { workout } from "$lib/stores/workoutStore.js";
    import Workout from "$lib/components/Workout.svelte";
    import Library from "$lib/components/Library.svelte";
    import Searched from "$lib/components/Searched.svelte";
    import Exercise from "$lib/components/Exercise.svelte";
    import {
        addExercises,
        searched,
        selectedExercise,
        filteredExercises,
        showLibrary,
        selectedExercises,
    } from "$lib/stores/exerciseStore.js"; //addExercises true menar att man väljer övningar från library

    let { data } = $props();

    if (!$workout && data.user) {
        workout.set({
            name: "Workout",
            date: new Date().toISOString().split("T")[0],
            duration: 0,
            exercises: [],
            volume: 0,
            sets: 0
        });
    }

</script>

<div class="content">

    <Workout />

    <div id="library">
        {#if $showLibrary === true}
            <section id="search">
                <Library {data} />
            </section>
        {/if}
    </div>
</div>

<style lang="scss">
    .content {
        align-items: flex-start;
        flex-direction: row;
        justify-content: flex-end;
    }

    #library {
        width: 28rem;
        #search {
            background-color: white;
            border: 0.1rem solid rgb(231, 231, 231);
            border-radius: 1.5rem;
            border-bottom: 0.3rem solid rgb(214, 214, 214);
            width: 28rem;
        }
    }
</style>
