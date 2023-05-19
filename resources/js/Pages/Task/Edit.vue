<template>
  <div>
    <Head :title="form.name" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/task">Tasks</Link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="task.deleted_at" class="mb-6" @restore="restore"> This task has been deleted. </trashed-message>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Name" />
          <text-input v-model="form.description" :error="form.errors.description" class="pb-8 pr-6 w-full lg:w-1/2" label="Description" />
          <select-input v-model="form.status_task_id" :error="form.errors.status_task_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Status">
            <option value="1">Creada</option>
            <option value="2">En progreso</option>
            <option value="3">Finalizada</option>
          </select-input>
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!task.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Task</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Task</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
  },
  layout: Layout,
  props: {
    task: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: this.task.name,
        description: this.task.description,
        status_task_id: this.task.status_task_id,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(`/task/${this.task.id}`)
    },
    destroy() {
      if (confirm('Are you sure you want to delete this task?')) {
        this.$inertia.delete(`/task/${this.task.id}`)
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this task?')) {
        this.$inertia.put(`/task/${this.task.id}/restore`)
      }
    },
  },
}
</script>
