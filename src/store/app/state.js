const user = JSON.parse(localStorage.getItem('currentUser'))
console.log(user)

export default function () {
  return {
    user: user || {},
    authenticated: user !== '',
    notifications: [
      {
        id: 1,
        user: {
          id: 1,
          name: 'Michael Smith',
          avatar: ''
        },
        content: '<span class="text-weight-bold">Michael Smith</span> create a support ticket #5425.',
        time: '1 minute ago',
        type: 'ticket_create'
      },
      {
        id: 2,
        user: {
          id: 1,
          name: 'Michael Smith',
          avatar: ''
        },
        content: '<span class="text-weight-bold">Michael Smith</span> request for disput #512.',
        time: '1 hours ago',
        type: 'disput'
      },
      {
        id: 3,
        user: {
          id: 1,
          name: 'Shail Smith',
          avatar: ''
        },
        content: '<span class="text-weight-bold">Shail Smith</span> added new product in wordpress theme.',
        time: '1 hours ago',
        type: 'add_product'
      },
      {
        id: 4,
        user: {
          id: 1,
          name: 'Shail Smith',
          avatar: ''
        },
        content: '<span class="text-weight-bold">Shail Smith</span> place an order #5451.',
        time: '1 hours ago',
        type: 'order'
      },
      {
        id: 5,
        user: {
          id: 1,
          name: 'Michael Smith',
          avatar: ''
        },
        content: '<span class="text-weight-bold">Michael Smith</span> reply on ticket #58524.',
        time: '1 hours ago',
        type: 'ticket_reply'
      }
    ]
  }
}
