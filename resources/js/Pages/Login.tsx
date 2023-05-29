import Layout from './Layout'
import LoginForm from './LoginForm'
import { Head } from '@inertiajs/react'

export default function Login(...args) {
  return (
    <Layout>
      <Head title="Welcome" />
      <LoginForm />
    </Layout>
  )
}

