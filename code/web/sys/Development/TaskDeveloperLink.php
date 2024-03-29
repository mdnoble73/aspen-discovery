<?php

class TaskDeveloperLink extends DataObject {
	public $__table = 'development_task_developer_link';
	public $id;
	public $userId;
	public $taskId;

	static function getObjectStructure($context = ''): array {
		$taskList = [];
		require_once ROOT_DIR . '/sys/Development/DevelopmentTask.php';
		$task = new DevelopmentTask();
		$task->find();
		while ($task->fetch()) {
			$taskList[$task->id] = $task->name;
		}

		$userList = [];
		$user = new User();
		$user->source = 'development';
		$user->find();
		while ($user->fetch()) {
			$userList[$user->id] = $user->displayName;
		}

		return [
			'id' => [
				'property' => 'id',
				'type' => 'label',
				'label' => 'Id',
				'description' => 'The unique id',
			],
			'userId' => [
				'property' => 'userId',
				'type' => 'enum',
				'values' => $userList,
				'label' => 'Developer',
				'description' => 'A developer working on this task',
				'required' => true,
			],
			'taskId' => [
				'property' => 'taskId',
				'type' => 'enum',
				'values' => $taskList,
				'label' => 'Task',
				'description' => 'The task being developed',
				'required' => true,
			],
		];
	}
}