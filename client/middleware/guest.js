export default function ({ store, redirect }) {
  if (store.getters['Auth/authenticated']) {
    return redirect('/Profile')
  }
}
