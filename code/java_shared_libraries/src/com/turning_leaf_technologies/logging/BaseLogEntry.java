package com.turning_leaf_technologies.logging;

public interface BaseLogEntry {
	void addNote(String note);

	boolean saveResults();

	void setFinished();

	void incErrors(String note);

	void incErrors(String note, Exception e);
}
