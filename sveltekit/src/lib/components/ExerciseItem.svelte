<!--$lib/components/Library.svelte-->
<script>
    import Selection from "./Selection.svelte";
    import { formatOption } from "../utils/format.js";
    import {
        selectedExercise,
        selectedExercises,
        searched,
        addExercises,
        exerciseArray,
    } from "$lib/stores/exerciseStore.js";

    let { exercise, view = "library" } = $props();

    let isSelected = $derived(
        $selectedExercises.some((ex) => ex.id === exercise.id),
    );

    let timer;
    let isLongPress = false;

    function Selected(exercise) {
        const exists = $selectedExercises.some((ex) => ex.id === exercise.id);

        if (!exists) {
            selectedExercises.update((exercises) => [...exercises, exercise]);

            console.log($selectedExercises.map((ex) => ex.name));
        } else {
            selectedExercises.update((exercises) =>
                exercises.filter((ex) => ex.id !== exercise.id),
            );

            console.log($selectedExercises.map((ex) => ex.name));
        }
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
    class:selected={isSelected}
    class="exercise-item"
>
    {#if $addExercises}
        <div class="hold-overlay">
            <span>Hold for info</span>
        </div>
    {/if}

    <div class="content-wrapper">
        {#if view === "library"}
            <!--För Library-->
            <h2>
                {exercise.name}
                <div class="exercise-meta">
                    <p>{formatOption(exercise.muscle)}</p>
                </div>
            </h2>
        {:else if view === "searched"}
            <!--För searched-->
            <h2 id="searched">{formatOption(exercise.name)}</h2>
            <div class="exercise-meta">
                <p class="psearch">
                    Primary Muscle:
                    <strong>{formatOption(exercise.muscle)}</strong>
                </p>
            </div>
            <p class="psearch">
                Equipments: <strong>
                    {exercise.equipments.map((e) => formatOption(e)).join(", ")}
                </strong>
            </p>
            <p class="psearch">
                Exercise Type:
                <strong>{formatOption(exercise.type)}</strong>
            </p>
            <p class="psearch">
                Difficulty:
                <strong>{formatOption(exercise.difficulty)}</strong>
            </p>
        {/if}
    </div>
</button>

<style lang="scss">
    .exercise-item {
        position: relative;
        overflow: hidden;
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

        .hold-overlay {
            position: absolute;
            top: 0;
            left: 0rem;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
            opacity: 0;
            transition: opacity 0.1s ease;
            pointer-events: none; 

            span {
                background-color: rgba(0, 0, 0, 0.6);
                color: white;
                padding: 0.5rem 1rem;
                border-radius: 2rem;
                font-size: 1.3rem;
                font-weight: bold;
                backdrop-filter: blur(
                    4px
                );
            }
        }

        &:hover {
            background-color: rgb(231, 231, 231);
            border-radius: 1rem;
            border-left: 0.5rem solid rgb(226, 226, 226);
            border-bottom: 0.5rem solid rgb(214, 214, 214);

            &:active {
                margin-top: 0.5rem;
                border-bottom: none;
            }

            .hold-overlay {
                opacity: 1;
            }
        }

        &.selected {
            background-color: #e3f2fd;
            border-left: 5px solid #2a7fd4;
            border-radius: 1rem;
            border-bottom: 0.5rem solid #1968b8;
            margin-bottom: 0.25rem;
            margin-top: 0.25rem;

            h2 {
                color: #1976d2;
            }

            .exercise-meta {
                color: #1976d2;
            }

            &:active {
                margin-top: 0.5rem;
                border-bottom: none;
                border-left: none;
            }
        }
    }
</style>
