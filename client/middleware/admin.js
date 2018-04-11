export default function ({store, redirect}) {
    if (!store.$auth.user.is_admin) {
        return redirect('/');
    }
}