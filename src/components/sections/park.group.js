import React from 'react'
import { Icon, Label, Menu, Table } from 'semantic-ui-react'


const handleRowClick = (post) => console.log(post.id)
const TableName = () => ( <Table.Header>
    <Table.Row >
      <Table.HeaderCell>Nom</Table.HeaderCell>
      <Table.HeaderCell>Adresse</Table.HeaderCell>
    </Table.Row>
  </Table.Header>)

const posts = [
  {id: 1, name: 'Parc Julien', address: '234 rue de la chapelle, sherbrooke, qc j0b 4g0'},
  {id: 2, name: 'PArc Victoria', address: '1258 rue du cégep, sherbrooke, qc ,j8b 4g0'}
];
const TableBody = () => (
     <Table.Body>
    {posts.map(post => <Table.Row key={post.id} onClick={handleRowClick.bind(this, post)}>
      <Table.Cell
        children = {post.name}>
      </Table.Cell>
      <Table.Cell
        children = {post.address}>
      </Table.Cell>
    </Table.Row>)}
  </Table.Body>
  )

const TableExamplePagination = () => (
  <Table celled >
   {TableName()}
   {TableBody()}
  </Table>
)

export default TableExamplePagination
