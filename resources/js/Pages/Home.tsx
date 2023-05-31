import Layout from './Layout'
import LoginForm from './LoginForm'
import { Head } from '@inertiajs/react'

export default function Home(...args) {
  return (
    <Layout>
      <Head title="Welcome" />
      <h1> Welcome Home! </h1>
      <h2> Ivite team</h2>
      <h2>Creat a session</h2>
      <h2>Open sesions</h2>
      <h2>Closed Sessions</h2>
    </Layout>
  )
}

