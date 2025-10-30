<script lang="ts">
    let {
        onUserRole, 
    }: {
        onUserRole?: (role: string) => void;
    } = $props();

    let userRole = $state('Loading...');

    async function fetchUserRole() {
        try {
            const response = await fetch('/checkRole', {
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'include',
            });

            if (!response.ok) {
                throw new Error(`HTTP error: ${response.status}`);
            }
            const data = await response.json();
            userRole = `User Role: ${data.role_name}`;
        } catch (error) {
            console.error(error);
            userRole = 'Error fetching user role';
        }
        onUserRole?.(userRole);
    }
    fetchUserRole();
</script>