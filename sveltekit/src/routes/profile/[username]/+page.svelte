<script>
    import ProfilePage from "$lib/components/ProfilePage.svelte";
    import { goto } from "$app/navigation";
    let { data } = $props();

    $inspect(data);

    let user = $derived(data.user);
    let visitedUser = $derived(data.visitedUser);

    // Check om jag hamnat på min egen sida via [username]
    $effect(() => {
        if (user?.uid === visitedUser?.uid) {
            goto("/profile");
        }
    });
</script>

<ProfilePage {data} isOwnProfile={false} />
