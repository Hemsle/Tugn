<!--$lib/components/Library.svelte-->
<script>
    import Selection from "./Selection.svelte";
    import { formatOption } from "../utils/format.js";

    export let data;

    const exercises = data.exercises || [];
    console.log("Exercises:", exercises);
    
</script>

<div id="library">
    <h1>Library</h1>
    <Selection {data} />
    <h2>All Exercises</h2>
</div>
<div class="exercise-list">
    {#each exercises as exercise}
        <div class="exercise-item">
            <h2>{exercise.name}
                <p>{formatOption(exercise.muscle)}</p>
            </h2>
            
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
        display: flex;
        flex-wrap: wrap;
        overflow-x: auto;
        height: 62rem;
        margin: 2rem;
        padding: 1rem;
        padding-top: 0rem;
        border: 0.1rem solid rgb(231, 231, 231);
        border-radius: 1.5rem;

        .exercise-item {
            width: 100%;
            padding: 2rem;
            padding-left: 1rem;
            text-align: left;
            h2{
                font-size: medium;
                p{
                    font-size: small;
                    font-weight: 100;
                }
            }

            &:hover {
                background-color: rgb(231, 231, 231);
                border: 0.1 rem solid rgb(231, 231, 231);
                border-radius: 1rem;
            }
        }
    }
</style>
