import Layout from './Layout'
import LoginForm from './LoginForm'
import { Head, Link } from '@inertiajs/react'

export default function Home({sessions, projects}) {

    const sessionList = sessions.map( (session) => {
        const id = session.id;
        const endDate = session.end_date;
        const viewHref = "sessions/"+id;
        const editHref = "sessions/"+id;
        return(
            <li>
                <strong>ID:</strong> {id} <strong>End Date:</strong> {endDate}
                &nbsp;
                <Link href={viewHref}>View</Link>
                &nbsp; | &nbsp;
                <Link href={editHref}>Edit</Link>
            </li>
        );
    });

  return (
    <Layout>
      <Head title="Welcome" />
      <h1> Welcome Home! </h1>
      <h2> Ivite team</h2>
      <h2>Creat a session</h2>
            <Link href='/sessions/create'> Create a new Session </Link>
      <h2>Open sesions</h2>
            <ul>{sessionList}</ul>
      <h2>Closed Sessions</h2>
    </Layout>
  )
}

