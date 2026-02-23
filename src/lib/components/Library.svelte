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
        filteredExercises,
        showLibrary
    } from "$lib/stores/exerciseStore.js";

    let { data } = $props();

    let selectedExercises = $state([]); //Array för att skicka valda övningar till en rutin

    const exercises = data.exercises || [];

    function toggleLibrary() {
        showLibrary.set(false);
        selectedExercise.set(null);
        filteredExercises.set([]);
        searched.set(false);
    }

</script>

<div id="library">
    <h1>Library 
        <button id="closeLibrary" onclick={toggleLibrary}>close</button>
    </h1>
    <Selection {data} />
    <h2>All Exercises</h2>
</div>

<div class="library-list">
    {#each exercises as exercise}
        <ExerciseItem {exercise} />
    {/each}
</div>

<style lang="scss">
    #library {
        height: 20%;
        margin: 2rem;
        h1{
            display: flex;
            justify-content: space-between;
        }
    }

    .library-list {
        overflow-x: auto;
        height: 73%;
        margin: 2rem;
        padding: 1rem;
        padding-top: 0rem;
        border: 0.1rem solid rgb(231, 231, 231);
        border-radius: 1.5rem;
    }
</style>
