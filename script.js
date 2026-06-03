// Ambil elemen HTML
const todoInput = document.getElementById('todo-input')
const addBtn = document.getElementById('add-btn')
const todoList = document.getElementById('todo-list')

// Ambil data dari localStorage
let todos = JSON.parse(localStorage.getItem('todos')) || []

// Render data ke layar
function renderTodos() {
    todoList.innerHTML = ''

    todos.forEach((todo) => {
        const li = document.createElement('li')

        li.className =
            'flex justify-between items-center p-3 border rounded'

        li.innerHTML = `
            <span onclick="toggleTodo(${todo.id})"
                style="cursor:pointer;
                ${todo.completed ? 'text-decoration:line-through; color:gray;' : ''}">
                ${todo.text}
            </span>

            <button onclick="deleteTodo(${todo.id})"
                style="color:red">
                Hapus
            </button>
        `

        todoList.appendChild(li)
    })

    localStorage.setItem('todos', JSON.stringify(todos))
}

// Tambah tugas
function addTodo() {
    const value = todoInput.value.trim()

    if (value === '') return

    const todoBaru = {
        id: Date.now(),
        text: value,
        completed: false
    }

    todos.push(todoBaru)

    renderTodos()
    todoInput.value = ''
}

// Tombol Add
addBtn.addEventListener('click', addTodo)

// Tombol Enter
todoInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        addTodo()
    }
})

// Tandai selesai
function toggleTodo(id) {
    todos = todos.map(todo =>
        todo.id === id
            ? { ...todo, completed: !todo.completed }
            : todo
    )

    renderTodos()
}

// Hapus tugas
function deleteTodo(id) {
    todos = todos.filter(todo => todo.id !== id)

    renderTodos()
}

// Tampilkan data saat halaman dibuka
renderTodos()