<!--$lib/components/Library.svelte-->
<script>
    export let data;

    const exercises = data.exercises || [];
    const muscles = data.muscles || [];

    console.log("Exercises:", exercises);
    console.log("Muscles:", muscles);
    let selectedExercise = "all_muscles";
    let selectedEquipment = "All_equipments"
</script>

<div class="library">
    <h1>Library</h1>
    <select bind:value={selectedExercise} id="exercise-select">
        <option value="all_muscles">All Muscles</option>s
        {#each muscles as muscle}
            <option value={muscle}>{muscle}</option>
        {/each}
    </select>
    <select bind:value={selectedEquipment} id="equipment-select">
        <option value="all_equipment">All Equipment</option>s
        {#each muscles as muscle}
            <option value={muscle}>{muscle}</option>
        {/each}
    </select>
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
    .library {
        height: 20%;
        margin: 2rem;
        h2 {
            position: absolute;
            top: 19rem;
        }
    }
    select {
        width: 10rem;
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

            img {
                display: inline-block;
                width: 5rem;
                height: 5rem;
                object-fit: contain; /* or "cover" depending on your preference */
                display: block;
            }
        }
    }
</style>
