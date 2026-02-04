<!--$lib/components/Library.svelte-->
<script>
    import Selection from "./Selection.svelte";
    import ExerciseItem from "./ExerciseItem.svelte";
    import { formatOption } from "../utils/format.js";
    import {
        selectedExercise,
        searched,
        addExercises,
        exerciseArray,
    } from "$lib/stores/exerciseStore.js";

    let { data } = $props();

    let selectedExercises = $state([]); //Array för att skicka valda övningar till en rutin

    const exercises = data.exercises || [];

</script>

<div id="library">
    <h1>Library</h1>
    <Selection {data} />
    <h2>All Exercises</h2>
</div>
<div class="exercise-list">
    {#each exercises as exercise}
        <ExerciseItem {exercise} />
    {/each}
</div>

<style lang="scss">
    #library {
        height: 20%;
        margin: 2rem;
        h2 {
            position: absolute;
            top: 19rem;
        }
    }
    
    .exercise-list {
        display: flex;
        flex-wrap: wrap;
        overflow-x: auto;
        height: 73%;
        margin: 2rem;
        padding: 1rem;
        padding-top: 0rem;
        border: 0.1rem solid rgb(231, 231, 231);
        border-radius: 1.5rem;
    }
</style>
