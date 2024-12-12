import React from 'react';


import { createRoot } from 'react-dom';


const Concurso = ({ customers }) => {
    return (
        <div>
            <table className="competicao-tabela">
                <thead>
                    <tr>
                        <th scope="col">Ranking</th>
                        <th scope="col">Tunas</th>
                        <th scope="col">Cerveja</th>
                        <th scope="col">Canecas</th>
                        <th scope="col">Shots</th>
                        <th scope="col">Pontos</th>
                    </tr>
                </thead>
                <tbody>
                    {customers.map((customer, index) => (
                        <tr key={customer.id}>
                            <td>{index + 1}º</td>
                            <td>
                                <figure>
                                    <a href={customer.instagram}><img src={customer.getAvatarUrl()} alt={customer.first_name} /></a>
                                    <figcaption>{customer.first_name}</figcaption>
                                </figure>
                            </td>
                            <td>{customer.getTotalCervejaOrdered()}</td>
                            <td>{customer.getTotalCanecaOrdered()}</td>
                            <td>{customer.getTotalShotsOrdered()}</td>
                            <td><b>{customer.getTotalPoints()}</b></td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
};

export default Concurso;

const root = document.getElementById('concurso');
if (root) {
    const rootInstance = createRoot(root);
    rootInstance.render(<Concurso />);
}
