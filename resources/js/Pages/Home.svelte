<script>
    import { inertia } from "@inertiajs/svelte";
    export let user;
    let username;
</script>

<svelte:head>
    <title>Login | OrgLink</title>
</svelte:head>
<h1 class="text-blue-500 text-3xl text-center">Welcome</h1>
<p class="text-2xl text-center">
    Hello Tenant {user}, welcome to OrgLink!<br /> I am @itsmenewbie04, your landlord!
</p>
<div class="w-full flex flex-col items-center mt-2">
    <input
        class="input input-bordered w-1/2"
        type="text"
        placeholder="Username"
        bind:value={username}
    />
    <!-- NOTE: what you see here isn't magic xD -->
    <button
        use:inertia={{
            method: "post",
            data: { user: username },
            href: "/user/show",
        }}
        class="btn btn-primary w-1/2 mt-2">Login</button
    >
</div>
