<script>
    import { goto } from "$app/navigation";
    import FollowStats from "./FollowStats.svelte";
    let { data } = $props();

    let profileUser = $derived(data.user);
</script>

<h1>{profileUser.username}</h1>
<h1 style="color: #666; font-weight: 400;">
    {profileUser.display_name}
</h1>

<FollowStats {profileUser} />

<button onclick={() => goto("/profile")}>See your profile</button>

<style lang="scss">
    h1 {
        font-size: 1.6rem;
    }

    button {
        display: flex;
        width: 100%;
        height: 4rem;
        justify-content: center;
        align-items: center;
        border-radius: 1rem;
        padding: 1rem;
    }
</style>
