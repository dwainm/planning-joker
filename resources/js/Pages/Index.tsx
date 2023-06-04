import Layout from './Layout'
import LoginForm from './LoginForm'
import { Head, Link } from '@inertiajs/react'

export default function Index({sessions, projects}) {

    const sessionList = sessions.map( (session) => {
        const id = session.id;
        const endDate = session.end_date;
        const viewHref = "sessions/"+id;
        const editHref = "sessions/"+id;
        return(
            <li className='Box-row'>
                <strong>ID:</strong> {id} <strong>End Date:</strong> {endDate}
                &nbsp;
                <Link href={viewHref}>View</Link>
                &nbsp; | &nbsp;
                <Link href={editHref}>Edit</Link>
            </li>
        );
    });

    return ( <Layout>
        <div className="Box">
            <div className="Box-header Box-header--gray">
                <h3 className="Box-title">Planning Joker</h3>
            </div>
            <div className="Box-body">

                <div class="clearfix">
                    <div class="col-6 float-left p-1">
                        <div className="Box mt-2 mb-2">
                            <div className="Box-header d-flex flex-items-center">
                                <h3 className="Box-title overflow-hidden flex-auto">
                                    Invite your team.
                                </h3>
                                <button className="btn btn-primary btn-sm">
                                    Invite Link(todo)
                                </button>
                            </div>
                            <div className="Box-body">
                                Nice paragraph describing what this is for and what you can do after inviting your team.
                            </div>
                        </div>
                    </div>
                    <div class="col-6 float-left p-1">
                        <div className="Box mt-2 mb-2">
                            <div className="Box-header d-flex flex-items-center">
                                <h3 className="Box-title overflow-hidden flex-auto">
                                    Creat a session
                                </h3>
                                <button href='/sessions/create' className="btn btn-primary btn-sm"> Create a new Session </button>
                            </div>
                            <div className="Box-body">
                                A session is a space where you and your team can vote on issues and finalize estimations together.
                            </div>
                        </div>
                    </div>
                </div>
                <div className="Box mt-2 mb-2">
                    <div className="Box-header Box-header--gray">
                        <h3 className="Box-title">Open sesions</h3>
                    </div>
                    <ul>{sessionList}</ul>
                </div>
                <div className="Box mt-2 mb-2">
                    <div className="Box-header Box-header--gray">
                        <h3 className="Box-title">Closed Sessions</h3>
                    </div>
                    <div className="Box-body">
                        <p> A list of sessions already closed </p>
                    </div>
                </div>
            </div>

        </div>
    </Layout>
    )
}
