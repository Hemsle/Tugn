<!--routes/emptyWorkout/+page.svelte-->
<script>

</script>
<section id="workout">
    <section><button>Close</button><h1>Log Workout</h1><button>Finish</button></section>
    <div>
        <p>Här kommer jag lägga duration, volume och sets</p>
    </div>

    <section>
        <h2>Här lägger man övningar sedan från API</h2>

        <div class="exercise"><p>För varje övning har en egen liten div</p></div>

        <button id="addExercise">
            <img src="/icons/plus.png" alt="plus">
            Add Exercise
        </button>

    </section>
</section>


<style lang="scss">
    #workout{
        display: flex;
        position: absolute;
        left: 35%;
        height: 70%;

        #addExercise{
            display: flex;
            width: 20rem;
            img {
                
            }
        }
    }
</style>
