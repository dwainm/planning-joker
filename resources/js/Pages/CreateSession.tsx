import Layout from './Layout'
import LoginForm from './LoginForm'
import { Head } from '@inertiajs/react'

export default function CreateSession(...args) {
  return (
    <Layout>
      <Head title="Welcome" />
      <h1>Create your session here.</h1>
    </Layout>
  )
}

