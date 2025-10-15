<!--$lib/components/Library.svelte-->
<script>
    import Selection from "./Selection.svelte";
    export let data;

    const exercises = data.exercises || [];

    console.log("Exercises:", exercises);
</script>

<div id="library">
    <h1>Library</h1>
    <Selection {data} />
    <h2>Exercises</h2>
</div>
<div class="exercise-list">
    {#each exercises as exercise}
        <div class="exercise-item">
            <h2>{exercise.name}</h2>
        </div>
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
        display: block;
        flex-wrap: wrap;
        overflow-x: auto;
        height: 62rem;
        margin: 2rem;
        padding: 1rem;
        border: 0.1rem solid rgb(231, 231, 231);
        border-radius: 1.5rem;

        .exercise-item {
            height: 7rem;
            padding: 0.5rem;
            text-align: left;
        }
    }
</style>
