import Layout from './Layout'
import {  router,Head, usePage } from '@inertiajs/react'
import { useState } from 'react'

export default function CreateSession(...args) {
  const [values, setValues] = useState({
  })

  function handleChange(e) {
    const key = e.target.id;
    const value = e.target.value
    setValues(values => ({
        ...values,
        [key]: value,
    }))
  }

    const ListProjects = ({projects}) => {
        return projects.map( (project) => {
            return (
                <option value={project.id}>{project.title}</option>
            )
        });
    }

    const handleSubmit = (e) => {
        e.preventDefault();
        router.post('/sessions', values)
    };

    return (
        <Layout>
            <Head title="Welcome" />
            <h1>Create your session here.</h1>
            <div className="col-6">
            <form onSubmit={handleSubmit}>
                    <select className='details-reset details-overlay' id="github-project-id-select" name="github-project-id-select" onChange={handleChange} >
                        <option>Select Project</option>
                        <ListProjects projects={usePage().props.projects} />
                    </select>
                    <input className="btn-mktg btn-muted-mktg btn-small-mktg mr-3" type="submit" value="Creat Session"/>
            </form>
            </div>
        </Layout>
    )
}

