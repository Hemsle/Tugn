<!--$lib/components/Library.svelte-->
<script>
    import Selection from "./Selection.svelte";
    import { formatOption } from "../utils/format.js";
    import {
        selectedExercise,
        searched,
        addExercises,
        exerciseArray,
    } from "$lib/stores/exerciseStore.js";

    let { exercise, view = "library" } = $props();

    let selectedExercises = $state([]); //Array för att skicka valda övningar till en rutin

    let timer;
    let isLongPress = false;

    function Selected(exercise) {
        console.log(exercise.name + " ska läggas till i array");
    }

    function MouseOver() {
        const element = document.getElementById("exercise-item");
        element.textContent = "This is the new text!";
    }
    function MouseDown(exercise) {
        isLongPress = false;

        if ($addExercises) {
            timer = setTimeout(() => {
                isLongPress = true;
                selectedExercise.set(exercise);
                searched.set(false);
            }, 1000);
        }
    }

    function MouseUp() {
        clearTimeout(timer);
    }

    function Select(exercise) {
        if (!$addExercises) {
            selectedExercise.set(exercise);
            searched.set(false);
        } else if (!isLongPress) {
            //till en lista som eventuellt ska in i routine...
            Selected(exercise);
        }
    }
</script>

<button
    type="button"
    onmousedown={() => MouseDown(exercise)}
    onmouseup={MouseUp}
    onmouseleave={MouseUp}
    onclick={() => Select(exercise)}
    class="exercise-item"
>   

    {#if view === "library"}
    <!--For Library-->
    <h2>
        {exercise.name}
        <div class="exercise-meta">
            <p>{formatOption(exercise.muscle)}</p>
            {#if $addExercises}
                <p class="hold-info">Hold for info</p>
            {/if}
        </div>
    </h2>

    {:else if view === "searched"}
    <!--For searched-->
    <div class="exercise-meta"><h2 id="searched">{exercise.name}</h2>
        {#if $addExercises}
        <p class="hold-info">Hold for info</p>
    {/if}
    </div>
    <p class="psearch">Primary Muscle: <strong><small>{formatOption(exercise.muscle)}</small></strong></p>
    <p class="psearch">Equipments: <strong><small>{exercise.equipments.map(e => formatOption(e)).join(', ')}</small></strong></p>
    <p class="psearch">Exercise Type: <strong><small>{formatOption(exercise.type)}</small></strong></p>
    <p class="psearch">Difficulty: <strong><small>{formatOption(exercise.difficulty)}</small></strong></p>

    {/if}
</button>

<style lang="scss">
    .exercise-item {
        font-family: "DM sans", sans-serif;
        background-color: white;
        border: none;
        width: 100%;
        padding: 1.5rem;
        padding-left: 1rem;
        text-align: left;
        border-bottom: 0.5rem solid rgb(255, 255, 255);
        h2 {
            font-size: medium;

            .exercise-meta {
                display: flex;
                gap: 2rem;
            }

            p {
                font-size: small;
                font-weight: 500;
            }
        }

        .exercise-meta {
                display: flex;
                gap: 9rem;
            }

        #searched {
            font-size: 2rem;
        }
        .psearch {
            font-size: 1.5rem;
            font-weight: 500;
        }

        .hold-info {
            display: flex;
            color: #888;
            font-weight: normal;
            opacity: 0;
            flex-direction: row-reverse;
            justify-content: flex-start;
        }

        &:hover {
            background-color: rgb(231, 231, 231);
            border: 0.1 rem solid rgb(231, 231, 231);
            border-radius: 1rem;
            border-bottom: 0.5rem solid rgb(214, 214, 214);

            &:active {
                margin-top: 0.5rem;
                border-bottom: none;
            }

            .hold-info {
                opacity: 1;
            }
        }
    }
</style>
