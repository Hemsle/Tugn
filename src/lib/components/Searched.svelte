<!--$lib/components/Searched.svelte-->

<script>
    import "./Selection.svelte";

    export let data;

    const exercises = data.exercises || [];
    let filteredExercises = [];

    function search() {//Koppla selection till searched för att göra en lista med anpassade övningar DETTA MÅSTE FIXAS
        const sMuscle = selectedMuscle;
        const sEquipment = selectedEquipment;
        const sType = selectedTypes;
        const sDifficulty = selectedDifficulty;

    console.log("Searched: " + sMuscle + ", " + sEquipment + ", " + sType + ", " + sDifficulty);

        filteredExercises = excercises.filter(exercises => {
            const muscleMatch = sMuscle === "all_muscles" || exercise.muscle === sMuscle;
            const equipmentMatch = sEquipment === "all_equipments" || exercise.equipment === sEquipment;
            const typeMatch = sType === "all_types" || exercise.type === sType;
            const difficultyMatch = sDifficulty === "all_difficulties" || exercise.difficulty === sDifficulty;

            return muscleMatch && equipmentMatch && typeMatch && difficultyMatch;
        });

        console.log("Filtered Exercises:", filteredExercises);

    }
</script>


<div class="exercise-list">
    {#each filteredExercises as exercise}
    <div>{exercise.name}</div>
    {/each}
</div>

<style lang="scss">
</style>
