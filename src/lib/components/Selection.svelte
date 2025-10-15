<!--$lib/componentes/Selection.svelte-->

<script>
    import Exercise from "./Exercise.svelte";
    import Searched from "./Searched.svelte";

    export let data;

    const exercises = data.exercises || [];
    const muscles = data.muscles || [];
    const equipments = data.equipments || [];
    const types = data.types || [];
    const difficulties = data.difficulties || [];

    console.log("Muscles:", muscles);
    console.log("Equipment:", equipments);
    console.log("Type:", types);
    console.log("Difficulty:", difficulties);

    let selectedMuscle = "all_muscles";
    let selectedEquipment = "all_equipments";
    let selectedTypes = "all_types";
    let selectedDifficulty = "all_difficulties";

    function formatOption(str) {
        if (!str) return "";
        return str
            .replace(/_/g, ' ')
            .replace(/-/g, '')        // Byt ut understreck mot mellanslag
            .replace(/\b\w/g, c => c.toUpperCase()); // Gör första bokstaven i varje ord stor
    }

    function handleSearch() {
        // Skicka de valda alternativen till parent/Searched
        dispatch('search', {
            muscle: selectedMuscle,
            equipment: selectedEquipment,
            type: selectedTypes,
            difficulty: selectedDifficulty
        });
    }
</script>

<select bind:value={selectedMuscle} id="muscle-select">
    <option value="all_muscles">All Muscles</option>
    {#each muscles as muscle}
        <option value={muscle}>{formatOption(muscle)}</option>
    {/each}
</select>
<select bind:value={selectedEquipment} id="equipment-select">
    <option value="all_equipments">All Equipments</option>
    {#each equipments as equipment}
        <option value={equipment}>{formatOption(equipment)}</option>
    {/each}
</select>
<select bind:value={selectedTypes} id="type-select">
    <option value="all_types">All Types</option>
    {#each types as type}
        <option value={type}>{formatOption(type)}</option>
    {/each}
</select>
<select bind:value={selectedDifficulty} id="difficulty-select">
    <option value="all_difficulties">All Difficulties</option>
    {#each difficulties as difficulty}
        <option value={difficulty}>{formatOption(difficulty)}</option>
    {/each}
</select>
<button on:click={handleSearch}>Search</button>

<style lang="scss">
    select {
        width: 12rem;
    }
</style>
